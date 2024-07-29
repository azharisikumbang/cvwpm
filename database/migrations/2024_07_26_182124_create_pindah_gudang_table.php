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
        Schema::create('pindah_gudang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_jalan')->index();
            $table->foreignId('gudang_asal_id')->constrained('gudang');
            $table->foreignId('gudang_tujuan_id')->constrained('gudang');
            $table->date('tanggal_pemindahan');
            $table->date('tanggal_penyelesaian')->nullable();
            $table->enum('jenis_pindah_gudang', ['KELUAR', 'MASUK'])->default('KELUAR');
            $table->string('surat_jalan_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pindah_gudang');
    }
};
