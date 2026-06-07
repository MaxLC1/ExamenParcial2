<?php

namespace Database\Seeders;

use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesProfesoresSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Coordinador (Solo lectura de reportes y gestión)
        User::updateOrCreate(
            ['email' => 'coordinador@ficct.edu.bo'],
            [
                'name' => 'Coordinador CUP',
                'password' => Hash::make('Password123'),
                'role' => 'coordinador',
                'email_verified_at' => now(),
            ]
        );

        // 2. Profesores por defecto
        $profesores = [
            ['email' => 'computacion@ficct.edu.bo', 'nombre' => 'Alan', 'apellido' => 'Turing', 'especialidad' => 'Computación', 'ci' => '5000001'],
            ['email' => 'matematicas@ficct.edu.bo', 'nombre' => 'Isaac', 'apellido' => 'Newton', 'especialidad' => 'Matemáticas', 'ci' => '5000002'],
            ['email' => 'fisica@ficct.edu.bo', 'nombre' => 'Albert', 'apellido' => 'Einstein', 'especialidad' => 'Física', 'ci' => '5000003'],
            ['email' => 'ingles@ficct.edu.bo', 'nombre' => 'William', 'apellido' => 'Shakespeare', 'especialidad' => 'Inglés', 'ci' => '5000004'],
        ];

        foreach ($profesores as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['nombre'] . ' ' . $p['apellido'],
                    'password' => Hash::make('Password123'),
                    'role' => 'profesor',
                    'email_verified_at' => now(),
                ]
            );

            Profesor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'ci' => $p['ci'],
                    'nombre' => $p['nombre'],
                    'apellido' => $p['apellido'],
                    'titulo_profesional' => 'Licenciatura en ' . $p['especialidad'],
                    'maestria' => true,
                    'diplomado_educacion_superior' => true,
                    'especialidad' => $p['especialidad'],
                    'telefono' => '70000000',
                    'activo' => true,
                ]
            );
        }

        // 3. Postulantes de Prueba
        $gestion = \App\Modules\P3GestionAcademica\Models\Gestion::first();
        if ($gestion) {
            $estudiantes = [
                ['email' => 'estudiante1@ficct.edu.bo', 'nombre' => 'Carlos', 'apellido_paterno' => 'Mendoza', 'ci' => '9000001'],
                ['email' => 'estudiante2@ficct.edu.bo', 'nombre' => 'Lucía', 'apellido_paterno' => 'Fernández', 'ci' => '9000002'],
                ['email' => 'estudiante3@ficct.edu.bo', 'nombre' => 'Roberto', 'apellido_paterno' => 'Gómez', 'ci' => '9000003'],
            ];

            foreach ($estudiantes as $e) {
                $user = User::updateOrCreate(
                    ['email' => $e['email']],
                    [
                        'name' => $e['nombre'] . ' ' . $e['apellido_paterno'],
                        'password' => Hash::make('Password123'),
                        'role' => 'postulante',
                        'email_verified_at' => now(),
                    ]
                );

                \App\Modules\P2GestionProfesoresPostulantes\Models\Postulante::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'gestion_id' => $gestion->id,
                        'ci' => $e['ci'],
                        'nombre' => $e['nombre'],
                        'apellido_paterno' => $e['apellido_paterno'],
                        'fecha_nacimiento' => '2005-01-15',
                        'sexo' => 'M',
                        'telefono' => '71111111',
                        'direccion' => 'Av. Estudiante 123',
                        'colegio_procedencia' => 'Colegio Nacional',
                        'ciudad' => 'Santa Cruz',
                        'titulo_bachiller' => true,
                        'estado' => 'inscrito',
                    ]
                );
            }
        }
    }
}
