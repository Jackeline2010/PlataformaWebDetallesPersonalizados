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
        Schema::table('clients', function (Blueprint $table) {
            // Add default values to all required fields
            $table->date('fingreso')->default('2025-01-01')->change();
            $table->string('telefono')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->boolean('activo')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Revert the changes
            $table->date('fingreso')->default(null)->change();
            $table->string('telefono')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->boolean('activo')->default(null)->change();
        });
    }
};
