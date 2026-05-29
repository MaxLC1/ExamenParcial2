<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P3GestionAcademica\Http\Controllers\P3GestionAcademicaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('p3gestionacademicas', P3GestionAcademicaController::class)->names('p3gestionacademica');
});
