<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('gestion_id')->constrained('gestiones')->onDelete('cascade');
            $table->string('ci', 20)->unique();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('sexo', 15);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('colegio_procedencia');
            $table->string('ciudad');
            $table->boolean('titulo_bachiller')->default(false);
            $table->enum('estado', ['inscrito', 'pagado', 'en_curso', 'aprobado', 'reprobado', 'asignado'])->default('inscrito');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->onDelete('set null');
            // Preferencias de carrera (1ª a 4ª opción)
            $table->foreignId('primera_opcion_carrera_id')->nullable()->constrained('carreras')->onDelete('set null');
            $table->foreignId('segunda_opcion_carrera_id')->nullable()->constrained('carreras')->onDelete('set null');
            $table->foreignId('tercera_opcion_carrera_id')->nullable()->constrained('carreras')->onDelete('set null');
            $table->foreignId('cuarta_opcion_carrera_id')->nullable()->constrained('carreras')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulantes');
    }
};
