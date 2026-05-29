<?php

namespace App\Modules\P2GestionProfesoresPostulantes\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P3GestionAcademica\Models\Carrera;
use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use App\Services\CalificacionService;
use App\Imports\PostulantesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PostulanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Postulante::with(['grupo', 'gestion']);

        if ($request->filled('gestion_id')) {
            $query->where('gestion_id', $request->gestion_id);
        }
        if ($request->filled('grupo_id')) {
            $query->where('grupo_id', $request->grupo_id);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ci', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido_paterno', 'like', "%{$search}%");
            });
        }

        $postulantes = $query->orderByDesc('created_at')->paginate(20);
        $gestiones = Gestion::orderByDesc('created_at')->get();

        return view('postulantes.index', compact('postulantes', 'gestiones'));
    }

    public function show(Postulante $postulante)
    {
        $postulante->load(['grupo', 'gestion', 'pagos', 'calificaciones.examen', 'asignacionCarrera.carrera']);

        $calificacionService = app(CalificacionService::class);
        $resumenNotas = $calificacionService->resumenNotasPostulante($postulante);

        return view('postulantes.show', compact('postulante', 'resumenNotas'));
    }

    public function edit(Postulante $postulante)
    {
        $carreras = Carrera::all();
        return view('postulantes.edit', compact('postulante', 'carreras'));
    }

    public function update(Request $request, Postulante $postulante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string|max:15',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'colegio_procedencia' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'titulo_bachiller' => 'boolean',
            'primera_opcion_carrera_id' => 'required|exists:carreras,id',
            'segunda_opcion_carrera_id' => 'required|exists:carreras,id',
            'tercera_opcion_carrera_id' => 'required|exists:carreras,id',
        ]);

        $postulante->update($validated);
        return redirect()->route('postulantes.index')->with('success', 'Postulante actualizado correctamente.');
    }

    public function destroy(Postulante $postulante)
    {
        if ($postulante->user) {
            $postulante->user->delete();
        } else {
            $postulante->delete();
        }
        return redirect()->route('postulantes.index')->with('success', 'Postulante eliminado correctamente.');
    }

    public function mostrarImportar()
    {
        return view('postulantes.importar');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new PostulantesImport, $request->file('archivo_excel'));
            return redirect()->route('postulantes.index')->with('success', 'Postulantes importados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function registro()
    {
        $gestionActual = Gestion::where('estado', 'inscripcion')->latest()->first();
        if (!$gestionActual) {
            return redirect()->route('login')->with('error', 'No hay una gestión en período de inscripción.');
        }
        $carreras = Carrera::all();
        return view('postulante.registro', compact('gestionActual', 'carreras'));
    }

    public function registrar(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:postulantes,ci',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'sexo' => 'required|string|max:15',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'colegio_procedencia' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'titulo_bachiller' => 'accepted',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'primera_opcion_carrera_id' => 'required|exists:carreras,id',
            'segunda_opcion_carrera_id' => 'required|exists:carreras,id|different:primera_opcion_carrera_id',
            'tercera_opcion_carrera_id' => 'required|exists:carreras,id|different:primera_opcion_carrera_id|different:segunda_opcion_carrera_id',
        ]);

        $gestion = Gestion::where('estado', 'inscripcion')->latest()->firstOrFail();

        DB::transaction(function () use ($validated, $gestion) {
            $user = User::create([
                'name' => $validated['nombre'] . ' ' . $validated['apellido_paterno'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'postulante',
            ]);

            Postulante::create([
                'user_id' => $user->id,
                'gestion_id' => $gestion->id,
                'ci' => $validated['ci'],
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'],
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'sexo' => $validated['sexo'],
                'telefono' => $validated['telefono'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
                'colegio_procedencia' => $validated['colegio_procedencia'],
                'ciudad' => $validated['ciudad'],
                'titulo_bachiller' => true,
                'primera_opcion_carrera_id' => $validated['primera_opcion_carrera_id'],
                'segunda_opcion_carrera_id' => $validated['segunda_opcion_carrera_id'],
                'tercera_opcion_carrera_id' => $validated['tercera_opcion_carrera_id'],
            ]);
        });

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puede iniciar sesión.');
    }
}
