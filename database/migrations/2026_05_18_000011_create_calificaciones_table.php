<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained('examenes')->onDelete('cascade');
            $table->foreignId('postulante_id')->constrained('postulantes')->onDelete('cascade');
            $table->decimal('nota', 5, 2)->default(0);
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->unique(['examen_id', 'postulante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
