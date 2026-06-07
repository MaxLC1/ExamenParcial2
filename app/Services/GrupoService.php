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
        
        // Obtener grupos existentes con su cantidad actual de postulantes
        $grupos = Grupo::where('gestion_id', $gestion->id)
            ->withCount('postulantes')
            ->orderBy('id')
            ->get();
            
        $gruposExistentes = $grupos->count();

        foreach ($postulantes as $postulante) {
            // Buscar el primer grupo que tenga espacio disponible
            $grupoDisponible = $grupos->first(function ($g) use ($capacidadPorGrupo) {
                return $g->postulantes_count < $capacidadPorGrupo;
            });

            // Si no hay grupos con espacio, creamos uno nuevo
            if (!$grupoDisponible) {
                // Determinar el nombre de la letra (A, B, C... Z, A1, B1...)
                $letraIndex = $gruposExistentes % 26;
                $ciclo = floor($gruposExistentes / 26);
                $sufijo = $ciclo > 0 ? $ciclo : '';
                $nuevoNombre = 'Grupo ' . chr(65 + $letraIndex) . $sufijo;

                $grupoDisponible = Grupo::create([
                    'gestion_id' => $gestion->id,
                    'nombre' => $nuevoNombre,
                    'capacidad_maxima' => $capacidadPorGrupo,
                    'aula' => 'Aula ' . ($gruposExistentes + 1),
                ]);
                
                // Inicializar el contador manualmente para la colección actual
                $grupoDisponible->postulantes_count = 0;
                
                $grupos->push($grupoDisponible);
                $gruposExistentes++;
            }

            // Asignar al grupo
            $postulante->update([
                'grupo_id' => $grupoDisponible->id,
                'estado' => 'en_curso',
            ]);

            // Incrementar el contador del grupo en memoria
            $grupoDisponible->postulantes_count++;
        }

        return [
            'total_postulantes' => $totalInscritos,
            'total_grupos' => $gruposExistentes,
            'postulantes_por_grupo' => "Distribución completada (Max: $capacidadPorGrupo por grupo)",
        ];
    }
}
