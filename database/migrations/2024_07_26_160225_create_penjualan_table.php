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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('nama_toko');
            $table->text('alamat_toko')->nullable();
            $table->string('kontak_toko')->nullable();
            $table->date('tanggal_transaksi');
            $table->foreignId('sales_canvas_id')->constrained('sales_canvases');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
