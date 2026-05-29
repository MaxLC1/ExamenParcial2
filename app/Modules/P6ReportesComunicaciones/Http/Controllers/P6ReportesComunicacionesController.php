<?php

namespace App\Modules\P6ReportesComunicaciones\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class P6ReportesComunicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('p6reportescomunicaciones::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('p6reportescomunicaciones::create');
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
        return view('p6reportescomunicaciones::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('p6reportescomunicaciones::edit');
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
