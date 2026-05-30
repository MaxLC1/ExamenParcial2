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

            $password = isset($row['password']) && !empty($row['password']) ? $row['password'] : 'Password123'; // Contraseña por defecto segura

            // Validar que la contraseña cumpla los requisitos de seguridad (sin exigir símbolos)
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['password' => $password],
                ['password' => ['required', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->numbers()]]
            );

            if ($validator->fails()) {
                throw new \Exception("La contraseña para {$row['email']} no es segura. Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.");
            }

            $user = User::create([
                'name' => $row['nombre'] ?? 'Usuario',
                'email' => $row['email'],
                'password' => Hash::make($password),
                'role' => $rol,
            ]);

            // Si es un profesor, crearle automáticamente su perfil en el Directorio
            if ($user->role === 'profesor') {
                $nombreParts = explode(' ', $user->name);
                $nombre = array_shift($nombreParts);
                $apellido = implode(' ', $nombreParts) ?: '-';

                // Capturar el CI del excel o generar uno temporal
                $ci = isset($row['ci']) && !empty($row['ci']) ? $row['ci'] : 'TMP-' . rand(10000, 99999);

                \App\Modules\P2GestionProfesoresPostulantes\Models\Profesor::create([
                    'user_id' => $user->id,
                    'ci' => $ci,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'especialidad' => 'Sin Especificar',
                    'activo' => true
                ]);
            }
        }
    }
}
