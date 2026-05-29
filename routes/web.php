<?php

use App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\ProfileController;
use App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\DashboardController;
use App\Modules\P3GestionAcademica\Http\Controllers\GestionController;
use App\Modules\P2GestionProfesoresPostulantes\Http\Controllers\ProfesorController;
use App\Modules\P2GestionProfesoresPostulantes\Http\Controllers\PostulanteController;
use App\Modules\P3GestionAcademica\Http\Controllers\GrupoController;
use App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers\ExamenController;
use App\Modules\P5PagosFacturacion\Http\Controllers\PagoController;
use App\Modules\P6ReportesComunicaciones\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// === CU1: Registro público de postulantes ===
Route::get('/postulante/registro', [PostulanteController::class, 'registro'])->name('postulante.registro');
Route::post('/postulante/registrar', [PostulanteController::class, 'registrar'])->name('postulante.registrar');

// === CU2: Autenticación y Panel de Control (Dashboard) ===
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::get('/run-migration', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    return 'Migración ejecutada con éxito: ' . \Illuminate\Support\Facades\Artisan::output();
});

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === ADMIN, COORDINADOR, AUTORIDAD (LECTURA) ===
    Route::middleware('role:admin,coordinador,autoridad')->prefix('admin')->group(function () {
        // CU3: Gestionar Gestiones Académicas (Lectura)
        Route::resource('gestiones', GestionController::class)->only(['index'])->parameters(['gestiones' => 'gestion']);

        // CU4: Gestionar Profesores (Lectura)
        Route::resource('profesores', ProfesorController::class)->only(['index'])->parameters(['profesores' => 'profesor']);

        // CU5: Gestionar Postulantes (Lectura)
        Route::get('postulantes', [PostulanteController::class, 'index'])->name('postulantes.index');
        Route::get('postulantes/{postulante}', [PostulanteController::class, 'show'])->where('postulante', '[0-9]+')->name('postulantes.show');

        // CU6: Gestionar Grupos (Lectura)
        Route::resource('grupos', GrupoController::class)->only(['index']);
        Route::get('grupos/{grupo}/asignar-materias', [GrupoController::class, 'asignarMaterias'])->name('grupos.asignar-materias');

        // CU8: Generar Reportes y Resultados (Lectura)
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('reportes/por-materia', [ReporteController::class, 'porMateria'])->name('reportes.por-materia');
        Route::get('reportes/por-profesor', [ReporteController::class, 'porProfesor'])->name('reportes.por-profesor');
        Route::get('reportes/por-carrera', [ReporteController::class, 'porCarrera'])->name('reportes.por-carrera');
    });

    // === SOLO ADMIN (ESCRITURA) ===
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // CU3: Gestionar Gestiones Académicas (Escritura)
        Route::resource('gestiones', GestionController::class)->except(['index'])->parameters(['gestiones' => 'gestion']);

        // CU4: Gestionar Profesores (Escritura)
        Route::resource('profesores', ProfesorController::class)->except(['index'])->parameters(['profesores' => 'profesor']);

        // CU5: Gestionar Postulantes (Importar, Editar, Eliminar)
        Route::get('postulantes/importar', [PostulanteController::class, 'mostrarImportar'])->name('postulantes.importar');
        Route::post('postulantes/importar', [PostulanteController::class, 'importar'])->name('postulantes.procesar-importacion');
        Route::get('postulantes/{postulante}/edit', [PostulanteController::class, 'edit'])->name('postulantes.edit');
        Route::put('postulantes/{postulante}', [PostulanteController::class, 'update'])->name('postulantes.update');
        Route::delete('postulantes/{postulante}', [PostulanteController::class, 'destroy'])->name('postulantes.destroy');

        // CU6: Gestionar Grupos (Escritura) y CU7: Asignar Postulantes a Grupos
        Route::resource('grupos', GrupoController::class)->except(['index']);
        Route::post('grupos/asignar-postulantes', [GrupoController::class, 'asignarPostulantes'])->name('grupos.asignar-postulantes');
        Route::post('grupos/{grupo}/guardar-asignacion', [GrupoController::class, 'guardarAsignacion'])->name('grupos.guardar-asignacion');
        Route::delete('grupos/{grupo}/asignacion/{asignacion}', [GrupoController::class, 'eliminarAsignacion'])->name('grupos.eliminar-asignacion');

        // CU8: Generar Reportes y Resultados (Asignar carreras finales)
        Route::post('reportes/asignar-carreras', [ReporteController::class, 'asignarCarreras'])->name('reportes.asignar-carreras');

        // CU9: Gestionar Exámenes Centralizado (Opcional para admin)
        Route::get('examenes', [ExamenController::class, 'index'])->name('examenes.index');
        Route::get('examenes/crear', [ExamenController::class, 'create'])->name('examenes.create');
        Route::post('examenes', [ExamenController::class, 'store'])->name('examenes.store');

        // CU12: Control Historial de Pagos
        Route::get('pagos', [PagoController::class, 'historial'])->name('pagos.historial');
        Route::delete('pagos/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');

        // CU13: Gestionar Usuarios y Roles
        Route::get('usuarios', [App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/importar', [App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\UsuarioController::class, 'mostrarImportar'])->name('usuarios.importar');
        Route::post('usuarios/importar', [App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\UsuarioController::class, 'importar'])->name('usuarios.procesar-importacion');
        Route::patch('usuarios/{usuario}/role', [App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\UsuarioController::class, 'updateRole'])->name('usuarios.update-role');
    });

    // === PROFESOR Y ADMIN (para calificar y asistencia) ===
    Route::middleware('role:profesor,admin')->prefix('profesor')->group(function () {
        // CU9: Programar Exámenes y CU11: Calificar Exámenes
        Route::get('examenes/{grupo_materia}/programar', [ExamenController::class, 'createProfesor'])->name('profesor.examenes.create');
        Route::post('examenes/{grupo_materia}/programar', [ExamenController::class, 'storeProfesor'])->name('profesor.examenes.store');
        Route::get('examenes/{examen}/calificar', [ExamenController::class, 'calificar'])->name('profesor.calificar');
        Route::post('examenes/{examen}/calificaciones', [ExamenController::class, 'guardarCalificaciones'])->name('profesor.guardar-calificaciones');
        
        // CU10: Registrar Asistencias
        Route::get('asistencias', [App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers\AsistenciaController::class, 'index'])->name('profesor.asistencias.index');
        Route::get('asistencias/{grupo_materia}/tomar', [App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers\AsistenciaController::class, 'tomar'])->name('profesor.asistencias.tomar');
        Route::post('asistencias/{grupo_materia}/guardar', [App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers\AsistenciaController::class, 'guardar'])->name('profesor.asistencias.guardar');
    });

    // === POSTULANTE ===
    Route::middleware('role:postulante')->prefix('mi')->group(function () {
        // CU12: Realizar Pago de Matrícula
        Route::get('pago', [PagoController::class, 'formulario'])->name('postulante.pago');
        Route::post('pago/procesar', [PagoController::class, 'procesar'])->name('postulante.pago.procesar');
    });
});

require __DIR__.'/auth.php';
