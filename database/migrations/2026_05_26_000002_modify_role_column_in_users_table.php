<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // En PostgreSQL para cambiar de enum a string a veces es necesario un DB::statement
        // O simplemente lo modificamos a string plano si Doctrine lo permite
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('postulante')->change();
        });
    }

    public function down(): void
    {
        // No hacer nada en el down o revertir al enum original
    }
};
