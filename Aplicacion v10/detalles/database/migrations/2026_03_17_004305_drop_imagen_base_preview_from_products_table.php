<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (Schema::hasColumn('products', 'imagen_base_preview')) {
                $table->dropColumn('imagen_base_preview');
            }

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->string('imagen_base_preview')->nullable();

        });
    }
};
