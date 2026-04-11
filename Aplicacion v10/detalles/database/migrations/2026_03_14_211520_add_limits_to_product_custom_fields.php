<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->string('selection_type', 20)
                ->default('single')
                ->after('type');

            $table->unsignedInteger('min_options')
                ->default(0)
                ->after('selection_type');

            $table->unsignedInteger('max_options')
                ->default(1)
                ->after('min_options');
        });
    }

    public function down(): void
    {
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->dropColumn([
                'selection_type',
                'min_options',
                'max_options',
            ]);
        });
    }
};
