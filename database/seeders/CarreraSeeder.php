<?php

namespace Database\Seeders;

use App\Modules\P3GestionAcademica\Models\Carrera;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            ['nombre' => 'Ingeniería Informática', 'codigo' => 'INF', 'descripcion' => 'Construcción de software, diseño de algoritmos y desarrollo de emprendimientos tecnológicos'],
            ['nombre' => 'Ingeniería en Sistemas', 'codigo' => 'SIS', 'descripcion' => 'Aplicación de tecnologías de información para la gestión industrial y empresarial'],
            ['nombre' => 'Ingeniería en Redes y Telecomunicaciones', 'codigo' => 'RED', 'descripcion' => 'Conectividad, procesamiento de señales, seguridad de redes y telecomunicaciones'],
            ['nombre' => 'Ingeniería en Robótica', 'codigo' => 'ROB', 'descripcion' => 'Mecánica, electrónica, inteligencia artificial y sistemas de control'],
        ];

        foreach ($carreras as $carrera) {
            Carrera::updateOrCreate(['codigo' => $carrera['codigo']], $carrera);
        }
    }
}
