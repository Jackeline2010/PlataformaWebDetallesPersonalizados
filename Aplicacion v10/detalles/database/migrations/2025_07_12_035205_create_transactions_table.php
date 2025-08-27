<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('payment_id')->constrained('payments')->onDelete('restrict');
            $table->string('numero_transaccion', 50)->unique();
            $table->string('referencia_externa', 100)->nullable(); // ID del procesador de pagos
            $table->enum('tipo', ['PAGO', 'REEMBOLSO', 'CANCELACION'])->default('PAGO');
            $table->enum('estado', ['PENDIENTE', 'PROCESANDO', 'COMPLETADO', 'FALLIDO', 'CANCELADO'])->default('PENDIENTE');
            $table->decimal('monto', 12, 2);
            $table->decimal('comision', 8, 2)->default(0);
            $table->decimal('monto_neto', 12, 2);
            $table->string('moneda', 3)->default('USD');
            $table->datetime('fecha_procesamiento')->nullable();
            $table->text('detalles_respuesta')->nullable(); // JSON con respuesta del procesador
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
