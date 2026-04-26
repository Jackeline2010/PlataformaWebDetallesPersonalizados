<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('tipo_arreglo')->nullable()->after('personalizable');
            $table->string('plantilla_preview')->nullable()->after('tipo_arreglo');
            $table->json('customization_zones')->nullable()->after('plantilla_preview');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_arreglo',
                'plantilla_preview',
                'customization_zones',
            ]);
        });
    }
};
