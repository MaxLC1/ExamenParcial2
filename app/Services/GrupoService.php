<?php

namespace App\Services;

use App\Modules\P3GestionAcademica\Models\Grupo;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;

class GrupoService
{
    /**
     * Distribuir postulantes pagados en grupos equitativamente.
     *
     * @param Gestion $gestion
     * @param int $capacidadPorGrupo (default 70)
     * @return array Resumen de la asignación
     */
    public function distribuirPostulantes(Gestion $gestion, int $capacidadPorGrupo = 70): array
    {
        $postulantes = Postulante::where('gestion_id', $gestion->id)
            ->where('estado', 'pagado')
            ->whereNull('grupo_id')
            ->get();

        if ($postulantes->isEmpty()) {
            return ['error' => 'No hay postulantes pagados sin grupo para asignar.'];
        }

        $totalInscritos = $postulantes->count();
        // Fórmula requerida: CEIL(TotalInscritos / 70)
        $numGrupos = (int) ceil($totalInscritos / $capacidadPorGrupo);

        // Crear grupos si no existen suficientes
        $gruposExistentes = Grupo::where('gestion_id', $gestion->id)->count();
        $gruposACrear = max(0, $numGrupos - $gruposExistentes);

        for ($i = 0; $i < $gruposACrear; $i++) {
            Grupo::create([
                'gestion_id' => $gestion->id,
                'nombre' => 'Grupo ' . chr(65 + $gruposExistentes + $i) . ($gruposExistentes + $i >= 26 ? ($gruposExistentes + $i - 25) : ''),
                'capacidad_maxima' => $capacidadPorGrupo,
                'aula' => 'Aula ' . ($gruposExistentes + $i + 1),
            ]);
        }

        $grupos = Grupo::where('gestion_id', $gestion->id)
            ->orderBy('id')
            ->get();

        // Distribución round-robin
        $index = 0;
        foreach ($postulantes as $postulante) {
            $grupo = $grupos[$index % $grupos->count()];
            $postulante->update([
                'grupo_id' => $grupo->id,
                'estado' => 'en_curso',
            ]);
            $index++;
        }

        return [
            'total_postulantes' => $totalInscritos,
            'total_grupos' => $grupos->count(),
            'postulantes_por_grupo' => (int) ceil($totalInscritos / $grupos->count()),
        ];
    }
}
