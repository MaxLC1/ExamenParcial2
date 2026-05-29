<?php

namespace App\Modules\P3GestionAcademica\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P3GestionAcademica\Models\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::orderByDesc('created_at')->paginate(10);
        return view('gestiones.index', compact('gestiones'));
    }

    public function create()
    {
        return view('gestiones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'cupo_informatica' => 'required|integer|min:0',
            'cupo_sistemas' => 'required|integer|min:0',
            'cupo_redes' => 'required|integer|min:0',
            'cupo_robotica' => 'required|integer|min:0',
        ]);

        Gestion::create($validated);

        return redirect()->route('gestiones.index')->with('success', 'Gestión creada exitosamente.');
    }

    public function edit(Gestion $gestion)
    {
        return view('gestiones.edit', compact('gestion'));
    }

    public function update(Request $request, Gestion $gestion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:planificacion,inscripcion,en_curso,finalizada',
            'cupo_informatica' => 'required|integer|min:0',
            'cupo_sistemas' => 'required|integer|min:0',
            'cupo_redes' => 'required|integer|min:0',
            'cupo_robotica' => 'required|integer|min:0',
        ]);

        $gestion->update($validated);

        return redirect()->route('gestiones.index')->with('success', 'Gestión actualizada exitosamente.');
    }

    public function destroy(Gestion $gestion)
    {
        $gestion->delete();
        return redirect()->route('gestiones.index')->with('success', 'Gestión eliminada.');
    }
}
