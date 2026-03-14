<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Verifica si existe el índice antes de eliminarlo
        $dbName = DB::getDatabaseName();

        $indexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $dbName)
            ->where('table_name', 'categories')
            ->where('index_name', 'categories_nombre_unique')
            ->exists();

        if ($indexExists) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropUnique('categories_nombre_unique');
            });
        }

        // (Opcional) si luego creabas un unique nuevo, lo dejas aquí
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->unique('nombre');
        // });
    }

    public function down(): void
    {
        // Solo si tu down() realmente necesita revertir:
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->unique('nombre', 'categories_nombre_unique');
        // });
    }
};
