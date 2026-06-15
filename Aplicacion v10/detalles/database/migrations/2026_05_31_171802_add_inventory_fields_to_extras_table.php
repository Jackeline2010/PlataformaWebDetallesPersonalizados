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
        Schema::table('extras', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('nombre');
            $table->integer('stock')->default(0)->after('precio_adicional');
            $table->integer('stock_minimo')->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn([
                'sku',
                'stock',
                'stock_minimo',
            ]);
        });
    }
};
