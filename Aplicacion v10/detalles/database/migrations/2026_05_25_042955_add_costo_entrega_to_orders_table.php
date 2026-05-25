<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {

        $table->decimal('costo_entrega', 10, 2)
            ->default(0)
            ->after('tipo_entrega');

        $table->string('metodo_pago')
            ->nullable()
            ->after('costo_entrega');

        $table->string('estado_pago')
            ->default('PENDIENTE')
            ->after('metodo_pago');

        $table->string('referencia_pago')
            ->nullable()
            ->after('estado_pago');

    });
}

    public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {

        $table->dropColumn([
            'costo_entrega',
            'metodo_pago',
            'estado_pago',
            'referencia_pago',
        ]);

    });
}
};
