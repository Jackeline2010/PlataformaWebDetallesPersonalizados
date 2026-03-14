<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('order_product_customizations')) {
            Schema::create('order_product_customizations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_product_id');
                $table->unsignedBigInteger('field_id');
                $table->unsignedBigInteger('option_id')->nullable();
                $table->text('value_text')->nullable();
                $table->decimal('extra_price', 12, 2)->default(0);
                $table->timestamps();

                $table->foreign('order_product_id')
                    ->references('id')->on('order_products')
                    ->cascadeOnDelete();

                $table->foreign('field_id')
                    ->references('id')->on('product_custom_fields')
                    ->restrictOnDelete();

                $table->foreign('option_id')
                    ->references('id')->on('product_custom_field_options')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // NO hacemos drop para evitar borrar datos por accidente
    }
};
