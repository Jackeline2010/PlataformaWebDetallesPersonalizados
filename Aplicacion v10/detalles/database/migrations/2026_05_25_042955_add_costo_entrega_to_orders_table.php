<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'costo_entrega')) {
                $table->decimal('costo_entrega', 10, 2)->default(0)->after('tipo_entrega');
            }

            if (!Schema::hasColumn('orders', 'metodo_pago')) {
                $table->string('metodo_pago')->nullable()->after('costo_entrega');
            }

            if (!Schema::hasColumn('orders', 'estado_pago')) {
                $table->string('estado_pago')->default('PENDIENTE')->after('metodo_pago');
            }

            if (!Schema::hasColumn('orders', 'referencia_pago')) {
                $table->string('referencia_pago')->nullable()->after('estado_pago');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'referencia_pago')) {
                $table->dropColumn('referencia_pago');
            }

            if (Schema::hasColumn('orders', 'estado_pago')) {
                $table->dropColumn('estado_pago');
            }

            if (Schema::hasColumn('orders', 'metodo_pago')) {
                $table->dropColumn('metodo_pago');
            }

            if (Schema::hasColumn('orders', 'costo_entrega')) {
                $table->dropColumn('costo_entrega');
            }
        });
    }
};
