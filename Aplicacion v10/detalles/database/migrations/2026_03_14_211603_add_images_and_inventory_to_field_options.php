<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_custom_field_options', function (Blueprint $table) {
            $table->string('image_thumb')
                ->nullable()
                ->after('label');

            $table->string('image_preview')
                ->nullable()
                ->after('image_thumb');

            $table->boolean('controls_inventory')
                ->default(true)
                ->after('is_active');

            $table->integer('stock')
                ->default(0)
                ->after('controls_inventory');

            $table->decimal('preview_x', 8, 2)->nullable();
            $table->decimal('preview_y', 8, 2)->nullable();
            $table->decimal('preview_width', 8, 2)->nullable();
            $table->decimal('preview_height', 8, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_custom_field_options', function (Blueprint $table) {
            $table->dropColumn([
                'image_thumb',
                'image_preview',
                'controls_inventory',
                'stock',
                'preview_x',
                'preview_y',
                'preview_width',
                'preview_height',
            ]);
        });
    }
};
