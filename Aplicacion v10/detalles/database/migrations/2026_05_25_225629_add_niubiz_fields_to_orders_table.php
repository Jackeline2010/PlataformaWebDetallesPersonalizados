<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_provider')) {
                $table->string('payment_provider')->nullable()->after('referencia_pago');
            }

            if (!Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->string('payment_transaction_id')->nullable()->after('payment_provider');
            }

            if (!Schema::hasColumn('orders', 'payment_url')) {
                $table->text('payment_url')->nullable()->after('payment_transaction_id');
            }

            if (!Schema::hasColumn('orders', 'payment_token')) {
                $table->text('payment_token')->nullable()->after('payment_url');
            }

            if (!Schema::hasColumn('orders', 'payment_session_key')) {
                $table->text('payment_session_key')->nullable()->after('payment_token');
            }

            if (!Schema::hasColumn('orders', 'payment_response')) {
                $table->json('payment_response')->nullable()->after('payment_session_key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_response')) {
                $table->dropColumn('payment_response');
            }

            if (Schema::hasColumn('orders', 'payment_session_key')) {
                $table->dropColumn('payment_session_key');
            }

            if (Schema::hasColumn('orders', 'payment_token')) {
                $table->dropColumn('payment_token');
            }

            if (Schema::hasColumn('orders', 'payment_url')) {
                $table->dropColumn('payment_url');
            }

            if (Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->dropColumn('payment_transaction_id');
            }

            if (Schema::hasColumn('orders', 'payment_provider')) {
                $table->dropColumn('payment_provider');
            }
        });
    }
};
