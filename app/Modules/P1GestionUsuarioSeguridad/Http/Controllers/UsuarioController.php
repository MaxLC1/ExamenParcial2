<?php

namespace App\Modules\P1GestionUsuarioSeguridad\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Imports\UsuariosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\P1GestionUsuarioSeguridad\Models\User;

class UsuarioController extends Controller
{
    public function mostrarImportar()
    {
        return view('usuarios.importar');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new UsuariosImport, $request->file('archivo_excel'));
            return back()->with('success', 'Usuarios importados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $usuarios = $query->orderBy('name')->paginate(20);
        return view('usuarios.index', compact('usuarios'));
    }

    public function updateRole(Request $request, User $usuario)
    {
        $request->validate([
            'role' => 'required|in:admin,profesor,postulante,autoridad,coordinador,otros'
        ]);

        $usuario->update(['role' => $request->role]);
        return back()->with('success', 'Rol del usuario ' . $usuario->name . ' actualizado correctamente.');
    }
}
