<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P4GestionEvaluacionAsistencia\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        // Obtener los grupos asignados al profesor autenticado
        $user = auth()->user();
        if ($user->role !== 'profesor' && $user->role !== 'admin') {
            abort(403, 'No autorizado');
        }

        $query = GrupoMateria::with(['grupo', 'materia']);
        
        if ($user->role === 'profesor') {
            $query->whereHas('profesor', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $gruposMateria = $query->get()->unique(function ($item) {
            return $item->grupo_id . '-' . $item->materia_id;
        });
        return view('asistencias.index', compact('gruposMateria'));
    }

    public function tomar(GrupoMateria $grupoMateria, Request $request)
    {
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        $postulantes = $grupoMateria->grupo->postulantes;
        
        // Obtener asistencias ya registradas para esta fecha
        $asistenciasPrevias = Asistencia::where('grupo_materia_id', $grupoMateria->id)
            ->whereDate('fecha', $fecha)
            ->get()
            ->keyBy('postulante_id');

        return view('asistencias.tomar', compact('grupoMateria', 'postulantes', 'fecha', 'asistenciasPrevias'));
    }

    public function guardar(Request $request, GrupoMateria $grupoMateria)
    {
        $request->validate([
            'fecha' => 'required|date',
            'asistencias' => 'required|array',
            'asistencias.*' => 'in:presente,ausente,licencia'
        ]);

        $fecha = $request->fecha;

        foreach ($request->asistencias as $postulante_id => $estado) {
            Asistencia::updateOrCreate(
                [
                    'grupo_materia_id' => $grupoMateria->id,
                    'postulante_id' => $postulante_id,
                    'fecha' => $fecha
                ],
                [
                    'estado' => $estado,
                ]
            );
        }

        return redirect()->route('profesor.asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }
}
