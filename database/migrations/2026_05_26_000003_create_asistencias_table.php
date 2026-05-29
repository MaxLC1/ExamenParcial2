<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_materia_id')->constrained('grupo_materia')->onDelete('cascade');
            $table->foreignId('postulante_id')->constrained('postulantes')->onDelete('cascade');
            $table->date('fecha');
            $table->enum('estado', ['presente', 'ausente', 'licencia'])->default('presente');
            $table->text('observacion')->nullable();
            $table->timestamps();

            // Un postulante no puede tener dos registros de asistencia en el mismo grupo_materia el mismo día
            $table->unique(['grupo_materia_id', 'postulante_id', 'fecha'], 'asistencia_unica');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
