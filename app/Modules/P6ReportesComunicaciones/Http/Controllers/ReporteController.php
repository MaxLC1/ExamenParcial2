<?php

namespace App\Modules\P6ReportesComunicaciones\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P3GestionAcademica\Models\Materia;
use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use App\Modules\P3GestionAcademica\Models\AsignacionCarrera;
use App\Modules\P3GestionAcademica\Models\Carrera;
use App\Services\CalificacionService;
use App\Services\AsignacionCarreraService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::orderByDesc('created_at')->get();
        return view('reportes.index', compact('gestiones'));
    }

    public function porMateria(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $gestion = Gestion::findOrFail($gestionId);

        $calService = app(CalificacionService::class);
        $materias = Materia::all();
        $reporteData = [];

        foreach ($materias as $materia) {
            $gmsAgrupados = GrupoMateria::where('materia_id', $materia->id)
                ->whereHas('grupo', fn($q) => $q->where('gestion_id', $gestionId))
                ->get()
                ->groupBy('grupo_id');

            $total = 0; $aprobados = 0; $sumaNotas = 0;

            foreach ($gmsAgrupados as $gmsGrupo) {
                $gm = $gmsGrupo->first();
                $postulantes = $gm->grupo->postulantes;
                foreach ($postulantes as $p) {
                    $nota = $calService->calcularNotaTotal($p->id, $gm->id);
                    $total++;
                    $sumaNotas += $nota;
                    if ($nota >= 60) $aprobados++;
                }
            }

            $reporteData[] = [
                'materia' => $materia->nombre,
                'total' => $total,
                'aprobados' => $aprobados,
                'reprobados' => $total - $aprobados,
                'porcentaje' => $total > 0 ? round(($aprobados / $total) * 100, 2) : 0,
                'promedio' => $total > 0 ? round($sumaNotas / $total, 2) : 0,
            ];
        }

        $formato = $request->get('formato', 'html');

        if ($formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.por-materia', compact('reporteData', 'gestion'));
            return $pdf->download("reporte_por_materia_{$gestion->nombre}.pdf");
        }

        return view('reportes.por-materia', compact('reporteData', 'gestion', 'gestionId'));
    }

    public function porProfesor(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $gestion = Gestion::findOrFail($gestionId);
        $calService = app(CalificacionService::class);

        $profesores = Profesor::whereHas('grupoMaterias.grupo', fn($q) => $q->where('gestion_id', $gestionId))->get();
        $reporteData = [];

        foreach ($profesores as $profesor) {
            $gmsAgrupados = $profesor->grupoMaterias()
                ->whereHas('grupo', fn($q) => $q->where('gestion_id', $gestionId))
                ->with(['materia', 'grupo.postulantes'])
                ->get()
                ->groupBy(function($item) {
                    return $item->grupo_id . '-' . $item->materia_id;
                });

            $totalAlumnos = 0; $totalAprobados = 0;
            $gruposUnicos = $profesor->grupoMaterias()
                ->whereHas('grupo', fn($q) => $q->where('gestion_id', $gestionId))
                ->get()
                ->pluck('grupo_id')->unique()->count();

            foreach ($gmsAgrupados as $gmsClase) {
                $gm = $gmsClase->first();
                foreach ($gm->grupo->postulantes as $p) {
                    $totalAlumnos++;
                    if ($calService->estaAprobado($p->id, $gm->id)) $totalAprobados++;
                }
            }

            $reporteData[] = [
                'profesor' => $profesor->nombre_completo,
                'grupos' => $gruposUnicos,
                'total_alumnos' => $totalAlumnos,
                'aprobados' => $totalAprobados,
                'porcentaje' => $totalAlumnos > 0 ? round(($totalAprobados / $totalAlumnos) * 100, 2) : 0,
            ];
        }

        usort($reporteData, fn($a, $b) => $b['porcentaje'] <=> $a['porcentaje']);

        $formato = $request->get('formato', 'html');
        if ($formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.por-profesor', compact('reporteData', 'gestion'));
            return $pdf->download("reporte_por_profesor_{$gestion->nombre}.pdf");
        }

        return view('reportes.por-profesor', compact('reporteData', 'gestion', 'gestionId'));
    }

    public function asignarCarreras(Request $request)
    {
        $gestionId = $request->get('gestion_id');
        $gestion = Gestion::findOrFail($gestionId);

        $service = app(AsignacionCarreraService::class);
        $resultado = $service->ejecutarAsignacion($gestion);

        return redirect()->route('reportes.por-carrera', ['gestion_id' => $gestionId])
            ->with('success', "Asignación completada: {$resultado['total_asignados']} asignados, {$resultado['sin_asignacion']} sin asignación.");
    }

    public function porCarrera(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $gestion = Gestion::findOrFail($gestionId);

        $carreras = Carrera::all();
        $reporteData = [];

        foreach ($carreras as $carrera) {
            $asignados = AsignacionCarrera::where('gestion_id', $gestionId)
                ->where('carrera_id', $carrera->id)
                ->where('estado', 'asignado')
                ->count();

            $reporteData[] = [
                'carrera' => $carrera->nombre,
                'codigo' => $carrera->codigo,
                'asignados' => $asignados,
            ];
        }

        $formato = $request->get('formato', 'html');
        if ($formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.por-carrera', compact('reporteData', 'gestion'));
            return $pdf->download("reporte_por_carrera_{$gestion->nombre}.pdf");
        }

        return view('reportes.por-carrera', compact('reporteData', 'gestion', 'gestionId'));
    }

    public function personalizado(Request $request)
    {
        $gestionId = $request->get('gestion_id', Gestion::latest()->first()?->id);
        $gestiones = Gestion::orderByDesc('created_at')->get();
        $materias = Materia::all();
        $profesores = Profesor::all();
        $carreras = Carrera::all();

        $columnasSeleccionadas = $request->get('columnas', ['ci', 'nombre', 'nota', 'estado', 'carrera_asignada']);
        $filtroMateria = $request->get('materia_id');
        $filtroEstado = $request->get('estado'); // 'aprobado', 'reprobado', 'todos'

        $reporteData = [];

        if ($request->isMethod('post') || $request->get('formato') === 'pdf') {
            $query = Postulante::whereHas('grupo', fn($q) => $q->where('gestion_id', $gestionId));
            $postulantes = $query->get();
            $calService = app(CalificacionService::class);

            foreach ($postulantes as $p) {
                if ($filtroMateria) {
                    $gm = $p->grupo->grupoMaterias()->where('materia_id', $filtroMateria)->first();
                    if (!$gm) continue;
                    $nota = $calService->calcularNotaTotal($p->id, $gm->id);
                } else {
                    $nota = 0;
                    $totalM = 0;
                    foreach ($p->grupo->grupoMaterias as $gm) {
                        $nota += $calService->calcularNotaTotal($p->id, $gm->id);
                        $totalM++;
                    }
                    if ($totalM > 0) $nota = $nota / $totalM; // Average
                }

                $estado = $nota >= 60 ? 'Aprobado' : 'Reprobado';

                if ($filtroEstado && $filtroEstado !== 'todos') {
                    if (strtolower($estado) !== strtolower($filtroEstado)) continue;
                }

                $asignacion = \App\Modules\P3GestionAcademica\Models\AsignacionCarrera::where('postulante_id', $p->id)
                    ->where('estado', 'asignado')
                    ->first();

                $reporteData[] = [
                    'ci' => $p->ci,
                    'nombre' => $p->nombre_completo,
                    'telefono' => $p->telefono ?? '-',
                    'email' => $p->email ?? '-',
                    'nota' => round($nota, 2),
                    'estado' => $estado,
                    'carrera_asignada' => $asignacion ? $asignacion->carrera->nombre : 'Sin Asignar',
                ];
            }
        }

        $formato = $request->get('formato', 'html');
        if ($formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.personalizado', compact('reporteData', 'columnasSeleccionadas'));
            return $pdf->download("reporte_personalizado.pdf");
        }

        return view('reportes.personalizado', compact('reporteData', 'columnasSeleccionadas', 'gestiones', 'gestionId', 'materias', 'carreras', 'filtroMateria', 'filtroEstado'));
    }
}
