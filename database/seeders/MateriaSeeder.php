<?php

namespace Database\Seeders;

use App\Modules\P3GestionAcademica\Models\Materia;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            ['nombre' => 'Computación', 'codigo' => 'COMP', 'descripcion' => 'Fundamentos de computación y programación'],
            ['nombre' => 'Matemáticas', 'codigo' => 'MAT', 'descripcion' => 'Álgebra, cálculo y matemáticas aplicadas'],
            ['nombre' => 'Física', 'codigo' => 'FIS', 'descripcion' => 'Física general y mecánica'],
            ['nombre' => 'Inglés', 'codigo' => 'ING', 'descripcion' => 'Inglés técnico y comunicación'],
        ];

        foreach ($materias as $materia) {
            Materia::updateOrCreate(['codigo' => $materia['codigo']], $materia);
        }
    }
}
