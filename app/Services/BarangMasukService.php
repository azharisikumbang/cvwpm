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

        $requestListBarang = collect($data['barang'])->keyBy('id');

        $listBarang = Barang::findMany(
            $requestListBarang->pluck('id')->toArray()
        );

        $listBarang->each(function (Barang $barang) use ($requestListBarang, $deliveryOrder) {
            $barang->tambahStok(
                jumlahDus: $requestListBarang[$barang->id]['jumlah_dus'],
                jumlahKotak: $requestListBarang[$barang->id]['jumlah_kotak'],
                jumlahSatuan: $requestListBarang[$barang->id]['jumlah_satuan']
            );

            RiwayatStok::create([
                'stokable_id' => $deliveryOrder->id,
                'stokable_type' => DeliveryOrder::class,
                'barang_id' => $barang->id,
                'jumlah_dus' => $requestListBarang[$barang->id]['jumlah_dus'],
                'jumlah_satuan' => $requestListBarang[$barang->id]['jumlah_satuan'],
                'jumlah_kotak' => $requestListBarang[$barang->id]['jumlah_kotak'],
            ]);
        });
    }
}