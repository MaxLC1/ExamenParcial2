<?php

namespace App\Modules\P2GestionProfesoresPostulantes\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::with('user')->orderBy('nombre')->paginate(15);
        return view('profesores.index', compact('profesores'));
    }

    public function registro()
    {
        return view('profesores.registro');
    }

    public function registrar(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:profesores,ci',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'titulo_profesional' => 'required|string|max:255',
            'especialidad' => 'required|string|in:Inglés,Matemáticas,Física,Computación',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'diplomado_educacion_superior' => 'accepted',
        ], [
            'diplomado_educacion_superior.accepted' => 'Debe poseer un título de educación (Diplomado en Educación Superior) de forma obligatoria.',
            'especialidad.required' => 'Debe seleccionar una especialidad.',
            'especialidad.in' => 'La especialidad seleccionada no es válida.',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['nombre'] . ' ' . $validated['apellido'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'profesor',
            ]);

            Profesor::create([
                'user_id' => $user->id,
                'ci' => $validated['ci'],
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'titulo_profesional' => $validated['titulo_profesional'],
                'maestria' => $request->has('maestria'),
                'diplomado_educacion_superior' => $request->has('diplomado_educacion_superior'),
                'especialidad' => $validated['especialidad'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'activo' => false, // Opcional: Requiere aprobación? lo dejaremos por default.
            ]);
        });

        return redirect()->route('login')->with('success', 'Registro de docente exitoso. Ahora puede iniciar sesión en el sistema académico.');
    }

    public function create()
    {
        $materias = \App\Modules\P3GestionAcademica\Models\Materia::all();
        return view('profesores.create', compact('materias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:profesores,ci',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'titulo_profesional' => 'required|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'maestria' => 'boolean',
            'diplomado_educacion_superior' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['nombre'] . ' ' . $validated['apellido'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['ci']),
                'role' => 'profesor',
            ]);

            Profesor::create([
                'user_id' => $user->id,
                'ci' => $validated['ci'],
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'titulo_profesional' => $validated['titulo_profesional'],
                'maestria' => $request->has('maestria'),
                'diplomado_educacion_superior' => $request->has('diplomado_educacion_superior'),
                'especialidad' => $validated['especialidad'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
            ]);
        });

        return redirect()->route('profesores.index')->with('success', 'Profesor registrado exitosamente.');
    }

    public function edit(Profesor $profesor)
    {
        $materias = \App\Modules\P3GestionAcademica\Models\Materia::all();
        return view('profesores.edit', compact('profesor', 'materias'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'titulo_profesional' => 'required|string|max:255',
            'maestria' => 'boolean',
            'diplomado_educacion_superior' => 'boolean',
            'especialidad' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ]);

        $validated['maestria'] = $request->has('maestria');
        $validated['diplomado_educacion_superior'] = $request->has('diplomado_educacion_superior');

        $profesor->update($validated);
        $profesor->user->update(['name' => $validated['nombre'] . ' ' . $validated['apellido']]);

        return redirect()->route('profesores.index')->with('success', 'Profesor actualizado.');
    }

    public function destroy(Profesor $profesor)
    {
        if ($profesor->grupoMaterias()->exists()) {
            return back()->with('error', 'No se puede eliminar un profesor con grupos asignados.');
        }

        $profesor->user->delete();
        return redirect()->route('profesores.index')->with('success', 'Profesor eliminado.');
    }
}
