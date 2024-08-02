<?php

namespace App\Services;

use App\Http\Requests\StorePindahGudangRequest;
use App\Http\Requests\StoreSalesCanvasRequest;
use App\Models\Gudang;
use App\Models\PindahGudang;
use App\Models\SalesCanvas;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\DB;
use PDF;

class PencatatanBarangKeluarService
{
    public function catatBarangKeluarSales(
        StoreSalesCanvasRequest $request
    ): ?SalesCanvas {

        $canvas = DB::transaction(function () use ($request) {
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
        });

        return $canvas ?? null;
    }

    public function catatBarangKeluarPindahGudang(
        Gudang $gudangAsal,
        StorePindahGudangRequest $request
    ): ?PindahGudang {
        $result = DB::transaction(function () use ($gudangAsal, $request) {
            $nomorSuratJalan = $this->generateNomorPindahGudang($gudangAsal);

            $pindahGudang = PindahGudang::create([
                'nomor_surat_jalan' => $nomorSuratJalan,
                'gudang_asal_id' => $gudangAsal->id,
                'gudang_tujuan_id' => $request->gudang_tujuan,
                'tanggal_pemindahan' => $request->tanggal_pemindahan,
                'surat_jalan_file' => $this->makeSuratJalanCanvas($nomorSuratJalan),
                'jenis_pindah_gudang' => PindahGudang::PINDAH_KELUAR,
            ]);

            $barangPindah = [];
            $requestBarang = $request->barang;
            foreach ($requestBarang as $b)
            {
                $barangPindah[] = RiwayatStok::make([
                    'barang_id' => $b['id'],
                    'jumlah_dus' => $b['jumlah_dus'],
                    'jumlah_kotak' => $b['jumlah_kotak'],
                    'jumlah_satuan' => $b['jumlah_satuan'],
                    'keterangan' => $b['keterangan'] ?? null,
                ]);
            }

            collect($pindahGudang->riwayatStok()->saveMany($barangPindah))->each(function ($riwayatStok) {
                $riwayatStok->barang->kurangiStok(
                    $riwayatStok->jumlah_dus,
                    $riwayatStok->jumlah_kotak,
                    $riwayatStok->jumlah_satuan
                );
            });

            return $pindahGudang;
        });

        return $result ?? null;
    }

    public function buatSuratJalanCanvas(SalesCanvas $salesCanvas)
    {
        $salesCanvas->load('riwayatStok.barang', 'sales');

        $pdf = PDF::loadView('export.pdf.surat-jalan-canvas', ['canvas' => $salesCanvas->toArray()]);
        $pdf->save(storage_path('app/public/surat-jalan-canvas/' . $salesCanvas->surat_jalan_file));
    }

    public function simpanSuratJalanPindahGudang(PindahGudang $pindahGudang)
    {
        $pindahGudang->load('riwayatStok.barang', 'gudangAsal', 'gudangTujuan');

        $pdf = PDF::loadView('export.pdf.surat-jalan-pindah-gudang', ['item' => $pindahGudang->toArray()]);
        // TODO: simpan di private storage
        $pdf->save(storage_path('app/public/surat-jalan-pindah-gudang/' . $pindahGudang->surat_jalan_file));
    }

    private function makeSuratJalanCanvas($suratJalan)
    {
        return md5($suratJalan) . '.pdf';
    }

    private function generateNomorSuratJalan(): string
    {
        $lastSalesCanvas = SalesCanvas::whereYear('tanggal_mulai', date('Y'))->latest()->first();

        if (!$lastSalesCanvas)
            return date('Y') . '/001';


        $lastNomorSuratJalan = $lastSalesCanvas->nomor_surat_jalan;
        $lastNumber = (int) explode('/', $lastNomorSuratJalan)[1];

        return sprintf('%s/%03d', date('Y'), $lastNumber + 1);
    }

    private function generateNomorPindahGudang(Gudang $gudangAsal): string
    {
        // format nomor surat jalan: 'TAHUN/BARR/BBT/KODE_GUDANG/BULAN/NOMOR_URUT'
        $lastPindahGudang = PindahGudang::whereYear('tanggal_pemindahan', date('Y'))->latest()->first();

        if (!$lastPindahGudang)
            return date('Y') . '/BARR/BBT/' . $gudangAsal->kode_gudang . '/' . date('m') . '/001';

        $lastNomorSuratJalan = $lastPindahGudang->nomor_surat_jalan;
        $lastNumber = (int) explode('/', $lastNomorSuratJalan)[5];

        return sprintf('%s/BARR/BBT/%s/%s/%03d', date('Y'), $gudangAsal->kode_gudang, date('m'), $lastNumber + 1);
    }
}