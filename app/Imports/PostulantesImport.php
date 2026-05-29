<?php

namespace App\Imports;

use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use App\Modules\P3GestionAcademica\Models\Gestion;
use App\Modules\P3GestionAcademica\Models\Carrera;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class PostulantesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $gestion = Gestion::where('estado', 'inscripcion')->latest()->first();

        if (!$gestion) {
            throw new \Exception('No hay una gestión en periodo de inscripción activa.');
        }

        $carrerasPorCodigo = Carrera::pluck('id', 'codigo')->toArray();
        $carrerasPorNombre = Carrera::pluck('id', 'nombre')->toArray();

        foreach ($rows as $row) {
            // Saltamos si no hay CI o email
            if (!isset($row['ci']) || !isset($row['email'])) {
                continue;
            }

            // Verificamos si ya existe el CI o el Email para no duplicar
            if (User::where('email', $row['email'])->exists() || Postulante::where('ci', $row['ci'])->exists()) {
                continue; 
            }

            DB::transaction(function () use ($row, $gestion, $carrerasPorCodigo, $carrerasPorNombre) {
                $user = User::create([
                    'name' => $row['nombre'] . ' ' . $row['apellido_paterno'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['ci']), // Contraseña por defecto: el CI
                    'role' => 'postulante',
                ]);

                // Asignamos carreras por defecto si no vienen
                $default1 = Carrera::first()->id;
                $default2 = Carrera::skip(1)->first()->id ?? $default1;
                $default3 = Carrera::skip(2)->first()->id ?? $default1;

                $getIdCarrera = function($valor) use ($carrerasPorCodigo, $carrerasPorNombre) {
                    if (!$valor) return null;
                    $valor = trim((string)$valor);
                    return $carrerasPorCodigo[$valor] ?? $carrerasPorNombre[$valor] ?? null;
                };

                $id_op1 = $getIdCarrera($row['opcion_1'] ?? null) ?? $default1;
                $id_op2 = $getIdCarrera($row['opcion_2'] ?? null) ?? $default2;
                $id_op3 = $getIdCarrera($row['opcion_3'] ?? null) ?? $default3;

                // Procesar la fecha de nacimiento para soportar dd-mm-yyyy o dd/mm/yyyy o fechas nativas de Excel
                $fecha_nac = '2000-01-01';
                if (!empty($row['fecha_nacimiento'])) {
                    try {
                        if (is_numeric($row['fecha_nacimiento'])) {
                            $fecha_nac = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento'])->format('Y-m-d');
                        } else {
                            // Convertir slashes a guiones ayuda a Carbon a interpretar dd-mm-yyyy
                            $fecha_str = str_replace('/', '-', $row['fecha_nacimiento']);
                            $fecha_nac = \Carbon\Carbon::parse($fecha_str)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $fecha_nac = '2000-01-01';
                    }
                }

                Postulante::create([
                    'user_id' => $user->id,
                    'gestion_id' => $gestion->id,
                    'ci' => (string) $row['ci'],
                    'nombre' => $row['nombre'],
                    'apellido_paterno' => $row['apellido_paterno'],
                    'apellido_materno' => $row['apellido_materno'] ?? null,
                    'fecha_nacimiento' => $fecha_nac,
                    'sexo' => ucfirst(strtolower($row['sexo'] ?? 'Masculino')),
                    'telefono' => $row['telefono'] ?? null,
                    'direccion' => $row['direccion'] ?? null,
                    'colegio_procedencia' => $row['colegio_procedencia'] ?? 'No especificado',
                    'ciudad' => $row['ciudad'] ?? 'Santa Cruz',
                    'titulo_bachiller' => true,
                    'estado' => 'pagado', // Para facilitar el examen, entran como pagados
                    'primera_opcion_carrera_id' => $id_op1,
                    'segunda_opcion_carrera_id' => $id_op2,
                    'tercera_opcion_carrera_id' => $id_op3,
                ]);
            });
        }
    }
}
