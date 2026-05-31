<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promotion_id')->nullable()->after('forma_pago_id')->constrained('promotions')->nullOnDelete();
            $table->string('promotion_code')->nullable()->after('promotion_id');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('promotion_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->dropColumn([
                'promotion_id',
                'promotion_code',
                'discount_amount',
            ]);
        });
    }
};
