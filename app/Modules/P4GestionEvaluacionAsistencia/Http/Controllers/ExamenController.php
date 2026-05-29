<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P4GestionEvaluacionAsistencia\Models\Examen;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P4GestionEvaluacionAsistencia\Models\Calificacion;
use App\Modules\P3GestionAcademica\Models\Grupo;
use App\Modules\P3GestionAcademica\Models\Gestion;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $examenes = Examen::with(['grupoMateria.grupo', 'grupoMateria.materia', 'grupoMateria.profesor'])
            ->whereHas('grupoMateria.grupo', fn($q) => $q->where('gestion_id', $gestionId))
            ->orderBy('fecha')
            ->paginate(20);
        $gestiones = Gestion::orderByDesc('created_at')->get();

        return view('examenes.index', compact('examenes', 'gestiones', 'gestionId'));
    }

    public function create()
    {
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])
            ->get()
            ->unique(function ($item) {
                return $item->grupo_id . '-' . $item->materia_id;
            });
            
        return view('examenes.create', compact('grupoMaterias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'tipo' => 'required|in:examen_1,examen_2,examen_3',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'aula_examen' => 'nullable|string|max:255',
        ]);

        $validated['puntaje_maximo'] = Examen::puntajeMaximoPorTipo($validated['tipo']);

        // Buscar el grupo y materia asociado al ID seleccionado
        $gmSeleccionado = GrupoMateria::findOrFail($validated['grupo_materia_id']);
        
        // Obtener todos los IDs de grupo_materia que corresponden a este mismo grupo y materia
        $gmIds = GrupoMateria::where('grupo_id', $gmSeleccionado->grupo_id)
            ->where('materia_id', $gmSeleccionado->materia_id)
            ->pluck('id');

        $existe = Examen::whereIn('grupo_materia_id', $gmIds)
            ->where('tipo', $validated['tipo'])->exists();
            
        if ($existe) {
            return back()->with('error', 'Ya existe un examen de este tipo para este grupo-materia.');
        }

        Examen::create($validated);
        return redirect()->route('examenes.index')->with('success', 'Examen programado.');
    }

    public function calificar(Examen $examen)
    {
        $examen->load(['grupoMateria.grupo.postulantes', 'grupoMateria.materia', 'calificaciones']);
        $postulantes = $examen->grupoMateria->grupo->postulantes;

        $calificaciones = $examen->calificaciones->keyBy('postulante_id');

        return view('examenes.calificar', compact('examen', 'postulantes', 'calificaciones'));
    }

    public function guardarCalificaciones(Request $request, Examen $examen)
    {
        $validated = $request->validate([
            'notas' => 'required|array',
            'notas.*' => 'required|numeric|min:0|max:' . $examen->puntaje_maximo,
        ]);

        foreach ($validated['notas'] as $postulanteId => $nota) {
            Calificacion::updateOrCreate(
                ['examen_id' => $examen->id, 'postulante_id' => $postulanteId],
                ['nota' => $nota]
            );
        }

        $examen->update(['estado' => 'finalizado']);

        return back()->with('success', 'Calificaciones guardadas exitosamente.');
    }

    public function createProfesor(GrupoMateria $grupoMateria)
    {
        if (auth()->user()->role === 'profesor' && $grupoMateria->profesor_id !== auth()->user()->profesor->id) {
            abort(403, 'No autorizado');
        }

        return view('examenes.profesor-create', compact('grupoMateria'));
    }

    public function storeProfesor(Request $request, GrupoMateria $grupoMateria)
    {
        if (auth()->user()->role === 'profesor' && $grupoMateria->profesor_id !== auth()->user()->profesor->id) {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'tipo' => 'required|in:examen_1,examen_2,examen_3',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'aula_examen' => 'nullable|string|max:255',
        ]);

        $validated['grupo_materia_id'] = $grupoMateria->id;
        $validated['puntaje_maximo'] = Examen::puntajeMaximoPorTipo($validated['tipo']);

        $gmIds = GrupoMateria::where('grupo_id', $grupoMateria->grupo_id)
            ->where('materia_id', $grupoMateria->materia_id)
            ->pluck('id');

        $existe = Examen::whereIn('grupo_materia_id', $gmIds)
            ->where('tipo', $validated['tipo'])->exists();
            
        if ($existe) {
            return back()->with('error', 'Ya existe un examen de este tipo programado para este grupo.');
        }

        Examen::create($validated);
        return redirect()->route('dashboard')->with('success', 'Examen programado exitosamente.');
    }
}
