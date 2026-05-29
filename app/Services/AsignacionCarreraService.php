<?php

namespace App\Services;

use App\Modules\P3GestionAcademica\Models\AsignacionCarrera;
use App\Modules\P3GestionAcademica\Models\Carrera;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;

class AsignacionCarreraService
{
    protected CalificacionService $calificacionService;

    public function __construct(CalificacionService $calificacionService)
    {
        $this->calificacionService = $calificacionService;
    }

    /**
     * Ejecutar algoritmo de asignación de postulantes a carreras.
     *
     * 1. Filtrar postulantes que aprobaron las 4 materias
     * 2. Ordenar por nota promedio general (descendente)
     * 3. Asignar según preferencia y cupos disponibles
     */
    public function ejecutarAsignacion(Gestion $gestion): array
    {
        $carreras = Carrera::all()->keyBy('codigo');
        $cupos = [
            $carreras['INF']->id => $gestion->cupo_informatica,
            $carreras['SIS']->id => $gestion->cupo_sistemas,
            $carreras['RED']->id => $gestion->cupo_redes,
            $carreras['ROB']->id => $gestion->cupo_robotica,
        ];

        $postulantes = Postulante::where('gestion_id', $gestion->id)
            ->whereIn('estado', ['en_curso', 'aprobado', 'asignado', 'rechazado'])
            ->whereNotNull('grupo_id')
            ->get();

        // Calcular promedios y filtrar aprobados
        $aprobados = [];
        foreach ($postulantes as $postulante) {
            if ($this->calificacionService->aproboTodasLasMaterias($postulante)) {
                $promedio = $this->calificacionService->calcularPromedioGeneral($postulante);
                $postulante->update(['estado' => 'aprobado']);
                $aprobados[] = [
                    'postulante' => $postulante,
                    'promedio' => $promedio,
                ];
            } else {
                $postulante->update(['estado' => 'reprobado']);
            }
        }

        // Ordenar por promedio descendente
        usort($aprobados, fn($a, $b) => $b['promedio'] <=> $a['promedio']);

        $asignados = 0;
        $sinAsignacion = 0;

        foreach ($aprobados as $item) {
            $postulante = $item['postulante'];
            $asignado = false;

            // Intentar asignar en orden de preferencia
            $opciones = [
                1 => $postulante->primera_opcion_carrera_id,
                2 => $postulante->segunda_opcion_carrera_id,
                3 => $postulante->tercera_opcion_carrera_id,
                4 => $postulante->cuarta_opcion_carrera_id,
            ];

            foreach ($opciones as $numOpcion => $carreraId) {
                if ($carreraId && isset($cupos[$carreraId]) && $cupos[$carreraId] > 0) {
                    AsignacionCarrera::updateOrCreate(
                        ['postulante_id' => $postulante->id, 'gestion_id' => $gestion->id],
                        [
                            'carrera_id' => $carreraId,
                            'opcion_numero' => $numOpcion,
                            'nota_promedio_general' => $item['promedio'],
                            'estado' => 'asignado',
                        ]
                    );

                    $cupos[$carreraId]--;
                    $postulante->update(['estado' => 'asignado']);
                    $asignados++;
                    $asignado = true;
                    break;
                }
            }

            if (!$asignado) {
                AsignacionCarrera::updateOrCreate(
                    ['postulante_id' => $postulante->id, 'gestion_id' => $gestion->id],
                    [
                        'carrera_id' => $carreras->first()->id,
                        'opcion_numero' => 0,
                        'nota_promedio_general' => $item['promedio'],
                        'estado' => 'rechazado',
                    ]
                );
                $postulante->update(['estado' => 'rechazado']);
                $sinAsignacion++;
            }
        }

        return [
            'total_postulantes' => $postulantes->count(),
            'total_aprobados' => count($aprobados),
            'total_asignados' => $asignados,
            'sin_asignacion' => $sinAsignacion,
            'cupos_restantes' => $cupos,
        ];
    }
}
