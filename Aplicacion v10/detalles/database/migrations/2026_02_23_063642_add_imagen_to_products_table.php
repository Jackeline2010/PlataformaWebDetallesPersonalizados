public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('imagen')->nullable()->after('precio'); // ajusta after si quieres
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('imagen');
    });
}
