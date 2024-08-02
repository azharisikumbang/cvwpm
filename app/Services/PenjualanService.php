<?php

namespace App\Services;

use App\Http\Requests\StorePenjualanCanvasRequest;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use App\Models\Staf;
use Illuminate\Support\Facades\DB;
use PDF;

class PenjualanService
{
    public function catatSales(
        Staf $sales,
        SalesCanvas $salesCanvas,
        StorePenjualanCanvasRequest $request
    ): false|Penjualan {
        $created = DB::transaction(function () use ($salesCanvas, $request) {
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

            return $penjualan;
        });

        return $created ?? false;
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

        return 'WPM' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function buatFakturPenjualan(Penjualan $penjualan)
    {
        $penjualan->load('riwayatStok.barang', 'salesCanvas');

        $suratJalanFile = md5($penjualan->nomor) . '.pdf';

        $pdf = PDF::loadView('export.pdf.faktur-penjualan', ['penjualan' => $penjualan->toArray()]);
        $pdf->save(storage_path('app/public/faktur-penjualan/' . $suratJalanFile));

        $penjualan->update(['file_faktur_penjualan' => $suratJalanFile]);
    }
}