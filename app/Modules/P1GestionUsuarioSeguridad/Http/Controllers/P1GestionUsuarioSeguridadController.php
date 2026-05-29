<?php

namespace App\Modules\P1GestionUsuarioSeguridad\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class P1GestionUsuarioSeguridadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('p1gestionusuarioseguridad::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('p1gestionusuarioseguridad::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('p1gestionusuarioseguridad::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('p1gestionusuarioseguridad::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
