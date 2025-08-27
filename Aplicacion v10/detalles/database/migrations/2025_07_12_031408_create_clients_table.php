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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('identificacion', 20)->unique();
            $table->string('nombres',100);
            $table->string('apellidos',100);
            $table->string('email')->unique();
            $table->string('telefono', 15)->nullable();
            $table->date('fnacimiento')->nullable();
            $table->enum('genero', ['M', 'F', 'O'])->nullable();
            $table->date('fingreso');
            $table->boolean('activo')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
