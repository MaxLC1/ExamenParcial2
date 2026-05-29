<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P5PagosFacturacion\Http\Controllers\P5PagosFacturacionController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('p5pagosfacturacions', P5PagosFacturacionController::class)->names('p5pagosfacturacion');
});
