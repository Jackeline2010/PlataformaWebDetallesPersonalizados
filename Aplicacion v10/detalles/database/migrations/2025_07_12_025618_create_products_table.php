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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->text('descripcion_corta')->nullable();
            $table->decimal('precio', 8, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(5);
            $table->date('fingreso');
            $table->decimal('descuento', 5, 2)->default(0.00);
            $table->string('imagen_principal')->nullable();
            $table->json('imagenes_adicionales')->nullable();
            $table->decimal('peso', 8, 2)->nullable(); // Para cálculo de envío
            $table->string('sku', 50)->unique()->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('destacado')->default(false);
            $table->boolean('personalizable')->default(false);
            $table->json('opciones_personalizacion')->nullable();
            $table->integer('orden')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['activo', 'destacado']);
            $table->index('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
