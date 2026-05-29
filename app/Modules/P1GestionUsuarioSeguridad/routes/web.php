<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P1GestionUsuarioSeguridad\Http\Controllers\P1GestionUsuarioSeguridadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('p1gestionusuarioseguridads', P1GestionUsuarioSeguridadController::class)->names('p1gestionusuarioseguridad');
});
