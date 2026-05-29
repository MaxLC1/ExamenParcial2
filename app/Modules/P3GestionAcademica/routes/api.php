<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P3GestionAcademica\Http\Controllers\P3GestionAcademicaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p3gestionacademicas', P3GestionAcademicaController::class)->names('p3gestionacademica');
});
