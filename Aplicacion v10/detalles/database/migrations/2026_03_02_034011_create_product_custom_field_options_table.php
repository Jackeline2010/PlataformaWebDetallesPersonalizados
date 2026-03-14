<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_custom_field_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');

            $table->string('label'); // Pequeño, Mediano, Grande
            $table->decimal('extra_price', 12, 2)->default(0);

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('field_id')
                ->references('id')->on('product_custom_fields')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_custom_field_options');
    }
};
