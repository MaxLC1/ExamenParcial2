<?php

namespace App\Services;

use App\Modules\P4GestionEvaluacionAsistencia\Models\Calificacion;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use Illuminate\Support\Collection;

class CalificacionService
{
    /**
     * Calcular la nota promedio total de un postulante en una materia.
     * Se calcula promediando la suma de los 3 exámenes (sobre 100 c/u).
     */
    public function calcularNotaTotal(int $postulanteId, int $grupoMateriaId): float
    {
        $grupoMateria = GrupoMateria::find($grupoMateriaId);

        if (!$grupoMateria) return 0;

        // Necesitamos todos los IDs de grupo_materia que correspondan al mismo grupo y materia
        $gmIds = GrupoMateria::where('grupo_id', $grupoMateria->grupo_id)
            ->where('materia_id', $grupoMateria->materia_id)
            ->pluck('id');

        $examenes = \App\Modules\P4GestionEvaluacionAsistencia\Models\Examen::with('calificaciones')
            ->whereIn('grupo_materia_id', $gmIds)
            ->get();

        $suma = 0;
        foreach ($examenes as $examen) {
            $calificacion = $examen->calificaciones
                ->where('postulante_id', $postulanteId)
                ->first();
            if ($calificacion) {
                $suma += $calificacion->nota;
            }
        }

        // El profesor califica cada examen sobre 100.
        // El sistema calcula automáticamente el promedio dividiendo entre 3.
        return round($suma / 3, 2);
    }

    /**
     * Verificar si un postulante aprobó una materia (nota >= 60).
     */
    public function estaAprobado(int $postulanteId, int $grupoMateriaId): bool
    {
        return $this->calcularNotaTotal($postulanteId, $grupoMateriaId) >= 60;
    }

    /**
     * Calcular el promedio general de un postulante en todas sus materias.
     */
    public function calcularPromedioGeneral(Postulante $postulante): float
    {
        if (!$postulante->grupo_id) return 0;

        $grupoMaterias = GrupoMateria::where('grupo_id', $postulante->grupo_id)->get()->groupBy('materia_id');

        if ($grupoMaterias->isEmpty()) return 0;

        $suma = 0;
        $count = 0;
        foreach ($grupoMaterias as $gms) {
            // Usamos el primer ID representativo de la materia
            $nota = $this->calcularNotaTotal($postulante->id, $gms->first()->id);
            $suma += $nota;
            $count++;
        }

        return $count > 0 ? round($suma / $count, 2) : 0;
    }

    /**
     * Verificar si un postulante aprobó todas las materias.
     */
    public function aproboTodasLasMaterias(Postulante $postulante): bool
    {
        if (!$postulante->grupo_id) return false;

        $grupoMaterias = GrupoMateria::where('grupo_id', $postulante->grupo_id)->get()->groupBy('materia_id');

        foreach ($grupoMaterias as $gms) {
            if (!$this->estaAprobado($postulante->id, $gms->first()->id)) {
                return false;
            }
        }

        return $grupoMaterias->isNotEmpty();
    }

    /**
     * Obtener resumen de notas de un postulante por materia.
     */
    public function resumenNotasPostulante(Postulante $postulante): Collection
    {
        if (!$postulante->grupo_id) return collect();

        $grupoMaterias = GrupoMateria::with(['materia', 'examenes.calificaciones'])
            ->where('grupo_id', $postulante->grupo_id)
            ->get()
            ->groupBy('materia_id');

        return collect($grupoMaterias)->map(function ($gms) use ($postulante) {
            $materia = $gms->first()->materia;
            $notas = [];
            
            foreach ($gms as $gm) {
                foreach ($gm->examenes as $examen) {
                    $cal = $examen->calificaciones->where('postulante_id', $postulante->id)->first();
                    $notas[$examen->tipo] = $cal ? $cal->nota : null;
                }
            }

            $total = $this->calcularNotaTotal($postulante->id, $gms->first()->id);

            return [
                'materia' => $materia->nombre,
                'parcial_1' => $notas['examen_1'] ?? null,
                'parcial_2' => $notas['examen_2'] ?? null,
                'final' => $notas['examen_3'] ?? null,
                'total' => $total,
                'aprobado' => $total >= 60,
            ];
        })->values();
    }
}
