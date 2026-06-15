public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('comprobante_pago')->nullable()->after('referencia_pago');
        $table->timestamp('fecha_pago_confirmado')->nullable()->after('comprobante_pago');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['comprobante_pago', 'fecha_pago_confirmado']);
    });
}
