<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P5PagosFacturacion\Http\Controllers\P5PagosFacturacionController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('p5pagosfacturacions', P5PagosFacturacionController::class)->names('p5pagosfacturacion');
});
