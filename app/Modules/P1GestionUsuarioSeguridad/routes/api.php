<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\P1GestionUsuarioSeguridadController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p1gestionusuarioseguridads', P1GestionUsuarioSeguridadController::class)->names('p1gestionusuarioseguridad');
});
