<?php

namespace App\Services;

use App\Http\Requests\StorePenjualanCanvasRequest;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use App\Models\Staf;

class PenjualanService
{
    public function catatSales(
        Staf $sales,
        SalesCanvas $salesCanvas,
        StorePenjualanCanvasRequest $request
    ) {
        $penjualan = Penjualan::create([
            'nomor' => $this->buatNomorPenjualan(),
            'sales_canvas_id' => $salesCanvas->id,
            'nama_toko' => $request->nama_toko,
            'alamat_toko' => $request->alamat_toko,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        $requestBarang = $request->barang;
        foreach ($requestBarang as $b)
        {
            $barangCanvas[] = RiwayatStok::make([
                'barang_id' => $b['id'],
                'jumlah_dus' => $b['jumlah_dus'],
                'jumlah_kotak' => $b['jumlah_kotak'],
                'jumlah_satuan' => $b['jumlah_satuan'],
                'keterangan' => $b['keterangan'] ?? null,
            ]);
        }

        $penjualan->riwayatStok()->saveMany($barangCanvas);
    }

    public function buatNomorPenjualan()
    {
        $lastPenjualan = Penjualan::latest()->first();
        if ($lastPenjualan)
        {
            $lastNumber = (int) substr($lastPenjualan->nomor, 3);
            $newNumber = $lastNumber + 1;
        } else
        {
            $newNumber = 1;
        }

        return 'CNV' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}