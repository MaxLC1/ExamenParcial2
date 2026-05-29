<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained('postulantes')->onDelete('cascade');
            $table->foreignId('gestion_id')->constrained('gestiones')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('referencia_transaccion')->unique()->nullable();
            $table->enum('metodo_pago', ['cartera_digital'])->default('cartera_digital');
            $table->enum('estado', ['pendiente', 'procesando', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->string('wallet_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
