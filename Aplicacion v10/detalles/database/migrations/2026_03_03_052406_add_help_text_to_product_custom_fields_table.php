<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

   public function up(): void
{
    if (!Schema::hasColumn('product_custom_fields', 'help_text')) {
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->string('help_text', 255)->nullable()->after('max_length');
        });
    }
}

    public function down(): void
    {
        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->dropColumn('help_text');
        });
    }
};
