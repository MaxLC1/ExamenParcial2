<?php

namespace App\Modules\P1GestionUsuarioSeguridad\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P3GestionAcademica\Models\Grupo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin() || in_array($user->role, ['autoridad', 'coordinador', 'otros'])) {
            return $this->adminDashboard($request);
        } elseif ($user->isProfesor()) {
            return $this->profesorDashboard($user);
        } elseif ($user->isPostulante()) {
            return $this->postulanteDashboard($user);
        }

        return view('dashboard');
    }

    private function adminDashboard(Request $request)
    {
        $gestiones = Gestion::all();
        
        // Ordenar lógicamente extrayendo Año y Periodo del nombre (Ej: II-2026 > I-2026 > II-2025)
        $gestiones = $gestiones->sortByDesc(function ($gestion) {
            // Intentamos buscar algo como "I-2025", "1-2025", "II-2026", "2-2026"
            if (preg_match('/(I{1,2}|1|2)\s*-\s*(\d{4})/i', $gestion->nombre, $matches)) {
                $p = strtoupper(trim($matches[1]));
                $periodo = ($p === 'II' || $p === '2') ? '2' : '1';
                $año = $matches[2];
                // Retornar un número suficientemente grande para que no choque con el fallback
                return intval($año . $periodo . '00000000'); 
            }
            // Fallback si no tiene formato de gestión académica
            return $gestion->fecha_inicio ? intval($gestion->fecha_inicio->format('Ymd') . $gestion->id) : 0;
        })->values();

        $gestionActual = null;

        if ($request->has('gestion_id')) {
            $gestionActual = $gestiones->firstWhere('id', $request->gestion_id);
        } else {
            $gestionActual = $gestiones->firstWhere('estado', 'activa') ?? $gestiones->first();
        }

        $gestionAnterior = null;
        $gestionSiguiente = null;

        if ($gestionActual) {
            $currentIndex = $gestiones->search(function ($g) use ($gestionActual) {
                return $g->id === $gestionActual->id;
            });

            if ($currentIndex !== false) {
                // Como está ordenado de más nuevo a más antiguo (desc):
                // 'Siguiente' (más nuevo) es el índice anterior (-1)
                // 'Anterior' (más viejo) es el índice siguiente (+1)
                if ($currentIndex > 0) {
                    $gestionSiguiente = $gestiones[$currentIndex - 1];
                }
                if ($currentIndex < $gestiones->count() - 1) {
                    $gestionAnterior = $gestiones[$currentIndex + 1];
                }
            }
        }

        $stats = [
            'total_inscritos' => $gestionActual ? Postulante::where('gestion_id', $gestionActual->id)->count() : 0,
            'total_aprobados' => $gestionActual ? Postulante::where('gestion_id', $gestionActual->id)->whereIn('estado', ['aprobado', 'asignado', 'rechazado'])->count() : 0,
            'total_reprobados' => $gestionActual ? Postulante::where('gestion_id', $gestionActual->id)->where('estado', 'reprobado')->count() : 0,
            'total_grupos' => $gestionActual ? Grupo::where('gestion_id', $gestionActual->id)->count() : 0,
            'gestion_actual' => $gestionActual,
            'gestion_anterior' => $gestionAnterior,
            'gestion_siguiente' => $gestionSiguiente,
        ];

        return view('dashboard.admin', $stats);
    }

    private function profesorDashboard($user)
    {
        $profesor = $user->profesor;
        $grupoMaterias = $profesor ? $profesor->grupoMaterias()->with(['grupo', 'materia', 'horario', 'examenes'])->get() : collect();
        $gruposAgrupados = $grupoMaterias->groupBy(function ($item) {
            return $item->grupo_id . '-' . $item->materia_id;
        });

        return view('dashboard.profesor', compact('profesor', 'gruposAgrupados'));
    }

    private function postulanteDashboard($user)
    {
        $postulante = $user->postulante;
        $grupoMaterias = collect();
        $calificaciones = collect();

        if ($postulante && $postulante->grupo_id) {
            $postulante->load('grupo.grupoMaterias.materia', 'grupo.grupoMaterias.examenes');
            $grupoMaterias = $postulante->grupo->grupoMaterias->groupBy('materia_id');
            $calificaciones = \App\Modules\P4GestionEvaluacionAsistencia\Models\Calificacion::where('postulante_id', $postulante->id)->get()->keyBy('examen_id');
        }

        return view('dashboard.postulante', compact('postulante', 'grupoMaterias', 'calificaciones'));
    }
}
