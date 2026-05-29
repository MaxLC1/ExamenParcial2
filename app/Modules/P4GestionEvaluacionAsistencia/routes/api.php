<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P4GestionEvaluacionAsistencia\Http\Controllers\P4GestionEvaluacionAsistenciaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p4gestionevaluacionasistencias', P4GestionEvaluacionAsistenciaController::class)->names('p4gestionevaluacionasistencia');
});
