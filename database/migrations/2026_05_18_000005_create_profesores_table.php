<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ci', 20)->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('especialidad')->nullable();
            $table->string('titulo_profesional')->nullable();
            $table->boolean('maestria')->default(false);
            $table->boolean('diplomado_educacion_superior')->default(false);
            $table->string('telefono', 20)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
