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
            // Modify the nombres and apellidos columns to have default values
            $table->string('nombres')->default('Cliente')->change();
            $table->string('apellidos')->default('Invitado')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Revert the nombres and apellidos columns to not have default values
            $table->string('nombres')->default(null)->change();
            $table->string('apellidos')->default(null)->change();
        });
    }
};
