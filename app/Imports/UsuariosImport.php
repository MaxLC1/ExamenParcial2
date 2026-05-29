<?php

namespace App\Imports;

use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsuariosImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Saltamos si no hay email o rol
            if (!isset($row['email']) || !isset($row['rol'])) {
                continue;
            }

            // Evitar duplicados
            if (User::where('email', $row['email'])->exists()) {
                continue;
            }

            // Normalizar el rol
            $rol = strtolower(trim($row['rol']));
            $rolesPermitidos = ['admin', 'profesor', 'docente', 'autoridad', 'coordinador', 'otros'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = 'otros'; // Por defecto si no coincide
            }

            // Si es docente, lo guardamos como profesor para mantener compatibilidad con el sistema actual
            if ($rol === 'docente') {
                $rol = 'profesor';
            }

            $password = isset($row['password']) ? $row['password'] : 'password123'; // Contraseña por defecto

            User::create([
                'name' => $row['nombre'] ?? 'Usuario',
                'email' => $row['email'],
                'password' => Hash::make($password),
                'role' => $rol,
            ]);
        }
    }
}
