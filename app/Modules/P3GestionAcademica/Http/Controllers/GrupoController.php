<?php

namespace App\Modules\P3GestionAcademica\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P3GestionAcademica\Models\Grupo;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P3GestionAcademica\Models\Materia;
use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use App\Modules\P4GestionEvaluacionAsistencia\Models\Horario;
use App\Services\GrupoService;
use App\Services\HorarioService;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $grupos = Grupo::with(['gestion', 'postulantes'])
            ->when($gestionId, fn($q) => $q->where('gestion_id', $gestionId))
            ->paginate(15);
        $gestiones = Gestion::orderByDesc('created_at')->get();

        return view('grupos.index', compact('grupos', 'gestiones', 'gestionId'));
    }

    public function create()
    {
        $gestiones = Gestion::orderByDesc('created_at')->get();
        return view('grupos.create', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gestion_id' => 'required|exists:gestiones,id',
            'nombre' => 'required|string|max:255',
            'capacidad_maxima' => 'required|integer|min:1|max:100',
            'aula' => 'nullable|string|max:255',
        ]);

        Grupo::create($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo creado.');
    }

    public function edit(Grupo $grupo)
    {
        $gestiones = Gestion::orderByDesc('created_at')->get();
        return view('grupos.edit', compact('grupo', 'gestiones'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'gestion_id' => 'required|exists:gestiones,id',
            'nombre' => 'required|string|max:255',
            'capacidad_maxima' => 'required|integer|min:1|max:100',
            'aula' => 'nullable|string|max:255',
        ]);

        $grupo->update($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy(Grupo $grupo)
    {
        if ($grupo->postulantes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un grupo que ya tiene postulantes asignados.');
        }

        $grupo->delete();
        return back()->with('success', 'Grupo eliminado correctamente.');
    }

    public function asignarPostulantes(Request $request)
    {
        $request->validate([
            'gestion_id' => 'required|exists:gestiones,id',
            'capacidad' => 'required|integer|min:30|max:100',
        ]);

        $gestion = Gestion::findOrFail($request->gestion_id);
        $service = app(GrupoService::class);
        $resultado = $service->distribuirPostulantes($gestion, $request->capacidad);

        if (isset($resultado['error'])) {
            return back()->with('error', $resultado['error']);
        }

        return back()->with('success', "Se distribuyeron {$resultado['total_postulantes']} postulantes en {$resultado['total_grupos']} grupos.");
    }

    public function asignarMaterias(Grupo $grupo)
    {
        $materias = Materia::all();
        $profesores = Profesor::where('activo', true)->get();
        $horarios = Horario::orderByRaw("CASE dia WHEN 'lunes' THEN 1 WHEN 'martes' THEN 2 WHEN 'miercoles' THEN 3 WHEN 'jueves' THEN 4 WHEN 'viernes' THEN 5 WHEN 'sabado' THEN 6 END")->orderBy('hora_inicio')->get();
        $horariosAgrupados = $horarios->groupBy('dia');
        
        $asignaciones = GrupoMateria::where('grupo_id', $grupo->id)->with(['materia', 'profesor', 'horario'])->get();

        return view('grupos.asignar-materias', compact('grupo', 'materias', 'profesores', 'horarios', 'horariosAgrupados', 'asignaciones'));
    }

    public function guardarAsignacion(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:profesores,id',
            'dias' => 'required|array',
            'dias.*.activo' => 'sometimes',
            'dias.*.horario_id' => 'required_with:dias.*.activo|exists:horarios,id',
            'dias.*.modalidad' => 'required_with:dias.*.activo|in:virtual,presencial',
        ]);

        $diasActivos = collect($validated['dias'])->filter(function ($dia) {
            return isset($dia['activo']);
        });

        if ($diasActivos->isEmpty()) {
            return back()->with('error', 'Debe seleccionar al menos un día en la programación semanal.');
        }

        $materia = Materia::findOrFail($validated['materia_id']);
        $profesor = Profesor::findOrFail($validated['profesor_id']);

        // Validación de especialidad ignorando tildes y mayúsculas
        $especialidadNormalizada = \Illuminate\Support\Str::slug($profesor->especialidad);
        $materiaNormalizada = \Illuminate\Support\Str::slug($materia->nombre);

        if ($profesor->especialidad && $especialidadNormalizada !== $materiaNormalizada) {
            return back()->with('error', "No puedes asignar esta materia. El profesor {$profesor->nombre_completo} es especialista en {$profesor->especialidad}.");
        }

        $horarioService = app(HorarioService::class);

        foreach ($diasActivos as $diaData) {
            $horario_id = $diaData['horario_id'];
            $modalidad = $diaData['modalidad'];

            if ($horarioService->tieneConflictoProfesor($validated['profesor_id'], $horario_id)) {
                return back()->with('error', 'El profesor tiene un conflicto en uno de los horarios seleccionados.');
            }

            if ($horarioService->excedeGruposProfesor($validated['profesor_id'])) {
                return back()->with('error', 'El profesor ya tiene el máximo de grupos asignados (5).');
            }

            GrupoMateria::firstOrCreate(
                [
                    'grupo_id' => $grupo->id, 
                    'materia_id' => $validated['materia_id'],
                    'horario_id' => $horario_id
                ],
                [
                    'profesor_id' => $validated['profesor_id'],
                    'modalidad_clase' => $modalidad,
                ]
            );
        }

        return back()->with('success', 'Programación semanal asignada exitosamente.');
    }

    public function eliminarAsignacion(Grupo $grupo, GrupoMateria $asignacion)
    {
        if ($asignacion->grupo_id !== $grupo->id) {
            abort(404);
        }
        $asignacion->delete();
        return back()->with('success', 'Asignación eliminada correctamente.');
    }
}
