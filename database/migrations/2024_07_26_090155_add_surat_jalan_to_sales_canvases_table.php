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
        Schema::table('sales_canvases', function (Blueprint $table) {
            $table->string('surat_jalan_file')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_canvases', function (Blueprint $table) {
            $table->dropColumn('surat_jalan_file');
        });
    }
};
