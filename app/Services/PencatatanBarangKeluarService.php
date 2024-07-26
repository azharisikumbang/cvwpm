<?php

namespace App\Services;

use App\Http\Requests\StoreSalesCanvasRequest;
use App\Models\SalesCanvas;
use App\Models\RiwayatStok;
use PDF;

class PencatatanBarangKeluarService
{
    public function catatBarangKeluarSales(
        StoreSalesCanvasRequest $request
    ): SalesCanvas {

        $nomorSuratJalan = $this->generateNomorSuratJalan();
        $canvas = SalesCanvas::create([
            'nomor_surat_jalan' => $nomorSuratJalan,
            'sales_id' => $request->sales,
            'wilayah' => $request->wilayah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'surat_jalan_file' => $this->makeSuratJalanCanvas($nomorSuratJalan),
        ]);

        $barangCanvas = [];
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

        collect($canvas->riwayatStok()->saveMany($barangCanvas))->each(function ($riwayatStok) {
            $riwayatStok->barang->kurangiStok(
                $riwayatStok->jumlah_dus,
                $riwayatStok->jumlah_kotak,
                $riwayatStok->jumlah_satuan
            );
        });

        return $canvas;
    }

    public function buatSuratJalanCanvas(SalesCanvas $salesCanvas)
    {
        $pdf = PDF::loadView('export.pdf.surat-jalan-canvas', ['canvas' => $salesCanvas]);
        $pdf->save(storage_path('app/public/surat-jalan-canvas/' . $salesCanvas->surat_jalan_file));
    }

    private function makeSuratJalanCanvas($suratJalan)
    {
        return md5($suratJalan) . '.pdf';
    }

    private function generateNomorSuratJalan(): string
    {
        $lastSalesCanvas = SalesCanvas::whereYear('tanggal_selesai', date('Y'))->latest()->first();

        if (!$lastSalesCanvas)
            return date('Y') . '/001';


        $lastNomorSuratJalan = $lastSalesCanvas->nomor_surat_jalan;
        $lastNumber = (int) explode('/', $lastNomorSuratJalan)[1];

        return sprintf('%s/%03d', date('Y'), $lastNumber + 1);
    }
}