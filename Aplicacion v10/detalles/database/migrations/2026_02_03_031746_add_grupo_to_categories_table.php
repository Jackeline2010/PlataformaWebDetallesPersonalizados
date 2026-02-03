<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('grupo', 50)
                ->default('tipo_producto')
                ->after('nombre');

            // Opcional pero recomendado para evitar duplicados por grupo+nombre
            $table->unique(['grupo', 'nombre'], 'categories_grupo_nombre_unique');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_grupo_nombre_unique');
            $table->dropColumn('grupo');
        });
    }
};
