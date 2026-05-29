<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_carrera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained('postulantes')->onDelete('cascade');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->foreignId('gestion_id')->constrained('gestiones')->onDelete('cascade');
            $table->integer('opcion_numero'); // 1-4
            $table->decimal('nota_promedio_general', 5, 2);
            $table->enum('estado', ['asignado', 'rechazado'])->default('asignado');
            $table->timestamps();

            $table->unique(['postulante_id', 'gestion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_carrera');
    }
};
