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
        Schema::create('sales_canvases', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_jalan')->unique();
            $table->foreignId('sales_id')->constrained('staf');
            $table->string('wilayah')->nullable();
            $table->date('tanggal_mulai')->default(now());
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_canvases');
    }
};
