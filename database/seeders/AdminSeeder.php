<?php

namespace Database\Seeders;

use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ficct.edu.bo'],
            [
                'name' => 'Administrador FICCT',
                'email' => 'admin@ficct.edu.bo',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
