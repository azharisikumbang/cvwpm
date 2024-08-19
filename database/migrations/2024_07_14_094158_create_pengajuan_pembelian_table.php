<?php

use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengajuan');
            $table->string('nomor_pengajuan')->unique();
            $table->enum('status_pengajuan', array_column(StatusPengajuanPembelian::cases(), 'value'))->default(StatusPengajuanPembelian::DRAFT->value);
            $table->text('catatan')->nullable();
            $table->foreignId('staf_pengaju_id')->constrained('staf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pembelian');
    }
};
