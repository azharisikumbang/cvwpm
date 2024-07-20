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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->string('nomor_po', 30);
            $table->foreignId('barang_id')->constrained('barang');
            $table->unsignedInteger('jumlah_dus')->default(0);
            $table->unsignedInteger('jumlah_kotak')->default(0);
            $table->timestamps();
            $table->primary(['nomor_po', 'barang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
