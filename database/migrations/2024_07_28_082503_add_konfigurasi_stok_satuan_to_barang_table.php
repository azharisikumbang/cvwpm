<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('satuan_per_dus')->default(0)->comment('jumlah satuan dalam satu dus');
            $table->integer('satuan_per_kotak')->default(0)->comment('jumlah satuan dalam satu kotak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('satuan_per_dus');
            $table->dropColumn('satuan_per_kotak');
        });
    }
};
