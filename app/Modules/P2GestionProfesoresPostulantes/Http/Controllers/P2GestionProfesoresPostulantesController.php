<?php

namespace App\Modules\P2GestionProfesoresPostulantes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class P2GestionProfesoresPostulantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('p2gestionprofesorespostulantes::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('p2gestionprofesorespostulantes::create');
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
        return view('p2gestionprofesorespostulantes::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('p2gestionprofesorespostulantes::edit');
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
