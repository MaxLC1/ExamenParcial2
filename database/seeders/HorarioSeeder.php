<?php

namespace Database\Seeders;

use App\Modules\P4GestionEvaluacionAsistencia\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $bloques = [
            // Turno mañana
            ['dia' => 'lunes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'aula' => null],
            ['dia' => 'lunes', 'hora_inicio' => '08:45', 'hora_fin' => '10:15', 'aula' => null],
            ['dia' => 'lunes', 'hora_inicio' => '10:30', 'hora_fin' => '12:00', 'aula' => null],
            ['dia' => 'martes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'aula' => null],
            ['dia' => 'martes', 'hora_inicio' => '08:45', 'hora_fin' => '10:15', 'aula' => null],
            ['dia' => 'martes', 'hora_inicio' => '10:30', 'hora_fin' => '12:00', 'aula' => null],
            ['dia' => 'miercoles', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'aula' => null],
            ['dia' => 'miercoles', 'hora_inicio' => '08:45', 'hora_fin' => '10:15', 'aula' => null],
            ['dia' => 'miercoles', 'hora_inicio' => '10:30', 'hora_fin' => '12:00', 'aula' => null],
            ['dia' => 'jueves', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'aula' => null],
            ['dia' => 'jueves', 'hora_inicio' => '08:45', 'hora_fin' => '10:15', 'aula' => null],
            ['dia' => 'jueves', 'hora_inicio' => '10:30', 'hora_fin' => '12:00', 'aula' => null],
            ['dia' => 'viernes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'aula' => null],
            ['dia' => 'viernes', 'hora_inicio' => '08:45', 'hora_fin' => '10:15', 'aula' => null],
            ['dia' => 'viernes', 'hora_inicio' => '10:30', 'hora_fin' => '12:00', 'aula' => null],
            // Turno tarde
            ['dia' => 'lunes', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'aula' => null],
            ['dia' => 'lunes', 'hora_inicio' => '15:45', 'hora_fin' => '17:15', 'aula' => null],
            ['dia' => 'martes', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'aula' => null],
            ['dia' => 'martes', 'hora_inicio' => '15:45', 'hora_fin' => '17:15', 'aula' => null],
            ['dia' => 'miercoles', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'aula' => null],
            ['dia' => 'miercoles', 'hora_inicio' => '15:45', 'hora_fin' => '17:15', 'aula' => null],
            ['dia' => 'jueves', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'aula' => null],
            ['dia' => 'jueves', 'hora_inicio' => '15:45', 'hora_fin' => '17:15', 'aula' => null],
            ['dia' => 'viernes', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'aula' => null],
            ['dia' => 'viernes', 'hora_inicio' => '15:45', 'hora_fin' => '17:15', 'aula' => null],
            // Sábado
            ['dia' => 'sabado', 'hora_inicio' => '08:00', 'hora_fin' => '09:30', 'aula' => null],
            ['dia' => 'sabado', 'hora_inicio' => '09:45', 'hora_fin' => '11:15', 'aula' => null],
            ['dia' => 'sabado', 'hora_inicio' => '11:30', 'hora_fin' => '13:00', 'aula' => null],
        ];

        foreach ($bloques as $bloque) {
            Horario::updateOrCreate(
                ['dia' => $bloque['dia'], 'hora_inicio' => $bloque['hora_inicio']],
                $bloque
            );
        }
    }
}
