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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index();
            $table->string('kemasan')->index();
            $table->string('satuan')->default('pcs');
            $table->double('harga')->default(0);
            $table->integer('jumlah_dus')->default(0);
            $table->integer('jumlah_satuan')->default(0);
            $table->integer('jumlah_kotak')->default(0);
            $table->foreignId('gudang_id')->constrained('gudang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
