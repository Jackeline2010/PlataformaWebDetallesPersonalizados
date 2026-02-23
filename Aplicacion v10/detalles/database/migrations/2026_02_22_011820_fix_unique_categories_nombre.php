<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Quita el unique actual: UNIQUE(nombre)
            $table->dropUnique('categories_nombre_unique');

            // Crea unique compuesto: UNIQUE(grupo, nombre)
            $table->unique(['grupo', 'nombre'], 'categories_grupo_nombre_unique');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_grupo_nombre_unique');
            $table->unique('nombre', 'categories_nombre_unique');
        });
    }
};
