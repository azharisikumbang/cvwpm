<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\DeliveryOrder;
use App\Models\PurchaseOrder;
use App\Models\RiwayatStok;

class BarangMasukService
{
    public function simpanDeliveryOrder(
        PurchaseOrder $purchaseOrder,
        array $data
    ): void {
        $deliveryOrder = DeliveryOrder::create([
            'nomor' => $data['nomor'],
            'tanggal_penerimaan' => $data['tanggal_penerimaan'],
            'purchase_order_id' => $purchaseOrder->id,
        ]);

        foreach ($data['barang'] as $barang)
        {
            $barangModel = Barang::findOrFail($barang['id']);

            $barangModel->update([
                'jumlah_dus' => $barangModel->jumlah_dus + $barang['jumlah_dus'],
                'jumlah_satuan' => $barangModel->jumlah_satuan + $barang['jumlah_satuan'],
                'jumlah_kotak' => $barangModel->jumlah_kotak + $barang['jumlah_kotak'],
            ]);

            RiwayatStok::create([
                'stokable_id' => $deliveryOrder->id,
                'stokable_type' => DeliveryOrder::class,
                'barang_id' => $barangModel->id,
                'jumlah_dus' => $barang['jumlah_dus'],
                'jumlah_satuan' => $barang['jumlah_satuan'],
                'jumlah_kotak' => $barang['jumlah_kotak'],
            ]);
        }
    }
}