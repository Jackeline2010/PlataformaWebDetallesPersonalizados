<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Esta migración no aplica en este proyecto,
        // porque la tabla product_personalizations no existe.
    }

    public function down(): void
    {
        // Sin cambios reversibles.
    }
};
