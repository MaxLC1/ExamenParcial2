<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P6ReportesComunicaciones\Http\Controllers\P6ReportesComunicacionesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p6reportescomunicaciones', P6ReportesComunicacionesController::class)->names('p6reportescomunicaciones');
});
