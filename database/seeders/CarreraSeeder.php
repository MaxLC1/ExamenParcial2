<?php

namespace Database\Seeders;

use App\Modules\P3GestionAcademica\Models\Carrera;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            ['nombre' => 'Ingeniería Informática', 'codigo' => '187-3', 'descripcion' => 'Construcción de software, diseño de algoritmos y desarrollo de emprendimientos tecnológicos'],
            ['nombre' => 'Ingeniería en Sistemas', 'codigo' => '187-4', 'descripcion' => 'Aplicación de tecnologías de información para la gestión industrial y empresarial'],
            ['nombre' => 'Ingeniería en Redes y Telecomunicaciones', 'codigo' => '187-5', 'descripcion' => 'Conectividad, procesamiento de señales, seguridad de redes y telecomunicaciones'],
            ['nombre' => 'Ingeniería en Robótica', 'codigo' => '323-0', 'descripcion' => 'Mecánica, electrónica, inteligencia artificial y sistemas de control'],
        ];

        foreach ($carreras as $carrera) {
            Carrera::updateOrCreate(['codigo' => $carrera['codigo']], $carrera);
        }
    }
}
