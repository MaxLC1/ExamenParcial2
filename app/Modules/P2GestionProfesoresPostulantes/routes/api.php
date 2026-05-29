<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P2GestionProfesoresPostulantes\Http\Controllers\P2GestionProfesoresPostulantesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p2gestionprofesorespostulantes', P2GestionProfesoresPostulantesController::class)->names('p2gestionprofesorespostulantes');
});
