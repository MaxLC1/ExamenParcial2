<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grupo_materia', function (Blueprint $table) {
            $table->dropUnique(['grupo_id', 'materia_id']);
            $table->unique(['grupo_id', 'materia_id', 'horario_id']);
        });
    }

    public function down(): void
    {
        Schema::table('grupo_materia', function (Blueprint $table) {
            $table->dropUnique(['grupo_id', 'materia_id', 'horario_id']);
            $table->unique(['grupo_id', 'materia_id']);
        });
    }
};
