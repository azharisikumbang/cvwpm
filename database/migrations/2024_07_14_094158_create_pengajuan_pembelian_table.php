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
        Schema::create('pengajuan_pembelian', function (Blueprint $table) {
            $table->id();
            // $table->date('tanggal_pengajuan'); // tidak dibutuhkan karena sudah ada created_at
            $table->enum('status', ['pending', 'approved', 'rejected', 'revised'])->default('pending');
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users');
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
