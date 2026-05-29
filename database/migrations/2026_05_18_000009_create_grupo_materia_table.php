<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
            $table->foreignId('horario_id')->nullable()->constrained('horarios')->onDelete('set null');
            $table->enum('modalidad_clase', ['virtual', 'presencial'])->default('virtual');
            $table->enum('modalidad_examen', ['presencial'])->default('presencial');
            $table->timestamps();

            $table->unique(['grupo_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_materia');
    }
};
