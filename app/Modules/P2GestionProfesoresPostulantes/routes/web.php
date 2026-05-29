<?php

use Illuminate\Support\Facades\Route;
use App\Modules\P2GestionProfesoresPostulantes\Http\Controllers\P2GestionProfesoresPostulantesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('p2gestionprofesorespostulantes', P2GestionProfesoresPostulantesController::class)->names('p2gestionprofesorespostulantes');
});
