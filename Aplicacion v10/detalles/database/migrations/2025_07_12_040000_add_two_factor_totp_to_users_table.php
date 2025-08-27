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
        Schema::table('users', function (Blueprint $table) {
            // Campos para 2FA TOTP (Time-based One-Time Password)
            $table->boolean('two_factor_enabled')->default(false)->after('password');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
            
            // Campos adicionales para seguridad
            $table->timestamp('two_factor_last_used_at')->nullable()->after('two_factor_confirmed_at');
            $table->integer('failed_login_attempts')->default(0)->after('two_factor_last_used_at');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');
            $table->timestamp('last_login_at')->nullable()->after('locked_until');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            
            // Índices para optimización
            $table->index('two_factor_enabled');
            $table->index('locked_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['two_factor_enabled']);
            $table->dropIndex(['locked_until']);
            
            $table->dropColumn([
                'two_factor_enabled',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
                'two_factor_last_used_at',
                'failed_login_attempts',
                'locked_until',
                'last_login_at',
                'last_login_ip'
            ]);
        });
    }
};
