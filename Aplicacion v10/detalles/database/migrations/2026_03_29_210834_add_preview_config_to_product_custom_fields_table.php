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
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->string('preview_type')->nullable()->after('type');
            $table->string('preview_target')->nullable()->after('preview_type');

            $table->integer('preview_x')->nullable()->after('preview_target');
            $table->integer('preview_y')->nullable()->after('preview_x');
            $table->integer('preview_width')->nullable()->after('preview_y');
            $table->integer('preview_height')->nullable()->after('preview_width');

            $table->integer('font_size')->nullable()->after('preview_height');
            $table->string('text_color', 20)->nullable()->after('font_size');

            $table->string('template_image')->nullable()->after('text_color');
            $table->string('mask_shape')->nullable()->after('template_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->dropColumn([
                'preview_type',
                'preview_target',
                'preview_x',
                'preview_y',
                'preview_width',
                'preview_height',
                'font_size',
                'text_color',
                'template_image',
                'mask_shape',
            ]);
        });
    }
};