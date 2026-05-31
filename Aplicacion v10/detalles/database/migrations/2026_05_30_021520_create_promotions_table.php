<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('codigo')->unique();

            $table->enum('tipo', ['porcentaje', 'monto_fijo']);
            $table->decimal('valor', 10, 2);

            $table->decimal('compra_minima', 10, 2)->default(0);

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->integer('limite_usos')->nullable();
            $table->integer('usos_actuales')->default(0);

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
