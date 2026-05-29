<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_materia_id')->constrained('grupo_materia')->onDelete('cascade');
            $table->enum('tipo', ['examen_1', 'examen_2', 'examen_3']);
            $table->integer('puntaje_maximo')->default(100);
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('aula_examen')->nullable();
            $table->enum('estado', ['programado', 'en_curso', 'finalizado'])->default('programado');
            $table->timestamps();

            $table->unique(['grupo_materia_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examenes');
    }
};
