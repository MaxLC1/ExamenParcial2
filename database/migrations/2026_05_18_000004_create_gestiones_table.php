<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gestiones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Gestión I-2026
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['planificacion', 'inscripcion', 'en_curso', 'finalizada'])->default('planificacion');
            $table->integer('cupo_informatica')->default(0);
            $table->integer('cupo_sistemas')->default(0);
            $table->integer('cupo_redes')->default(0);
            $table->integer('cupo_robotica')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestiones');
    }
};
