<?php

namespace App\Services;

use App\Http\Requests\StorePindahGudangTujuanRequest;
use App\Models\Barang;
use App\Models\DeliveryOrder;
use App\Models\PindahGudang;
use App\Models\PurchaseOrder;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use Illuminate\Support\Facades\DB;

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
            $requestListBarang->select('id')->toArray()
        );

        // dd($requestListBarang, $listBarang->toArray());

        $purchaseOrder->load('riwayatStok');
        $listBarangPO = $purchaseOrder->riwayatStok->select('barang_id', 'jumlah_dus', 'jumlah_kotak', 'jumlah_satuan')->keyBy('barang_id');

        $poLunas = true;
        /** @var Barang $barang */
        $listBarang->map(function (Barang $barang) use ($requestListBarang, $deliveryOrder, $listBarangPO, &$poLunas) {
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

            if ($this->cekStatusJumlahPOdanDO($listBarangPO, $requestListBarang, $barang))
                $poLunas = false;
        });

        if ($poLunas)
        {
            $purchaseOrder->markAsComplete();
            $deliveryOrder->markAsComplete();
        }
    }

    public function catatSisaCanvas(SalesCanvas $canvas)
    {
        if ($canvas->is_done)
            return;

        // sisa canvas adalah barang yang tidak terjual
        // didapatkan dari jumlah barang yang dijual - jumlah barang yang ada di muatan

        $canvas->load('penjualan.riwayatStok.barang', 'riwayatStok.barang');

        $canvas->riwayatStok->map(function (RiwayatStok $riwayatStok) use ($canvas) {
            $barang = $riwayatStok->barang;

            $jumlahTerjualDus = $canvas->penjualan->sum(function ($penjualan) use ($barang) {
                return $penjualan->riwayatStok->where('barang_id', $barang->id)->sum('jumlah_dus');
            });

            $jumlahTerjualKotak = $canvas->penjualan->sum(function ($penjualan) use ($barang) {
                return $penjualan->riwayatStok->where('barang_id', $barang->id)->sum('jumlah_kotak');
            });

            $jumlahTerjualSatuan = $canvas->penjualan->sum(function ($penjualan) use ($barang) {
                return $penjualan->riwayatStok->where('barang_id', $barang->id)->sum('jumlah_satuan');
            });

            $sisaDus = $riwayatStok->jumlah_dus - $jumlahTerjualDus;
            $sisaKotak = $riwayatStok->jumlah_kotak - $jumlahTerjualKotak;
            $sisaSatuan = $riwayatStok->jumlah_satuan - $jumlahTerjualSatuan;

            $barang->tambahStok(
                jumlahDus: $sisaDus,
                jumlahKotak: $sisaKotak,
                jumlahSatuan: $sisaSatuan
            );
        });

        $canvas->markAsDone();
    }

    public function catatBarangMasukPindahGudangOtomatis(
        PindahGudang $pindahGudang,
        StorePindahGudangTujuanRequest $request,
        BarangService $barangService
    ) {
        DB::transaction(function () use ($pindahGudang, $request, $barangService) {
            $pindahGudang->load('riwayatStok.barang', 'gudangTujuan');

            $tanggalPenyelesaian = now();
            $pindahGudang->update([
                'tanggal_penyelesaian' => $tanggalPenyelesaian,
            ]);
            $pindahGudangMasuk = PindahGudang::create([
                'gudang_asal_id' => $pindahGudang->gudang_asal_id,
                'gudang_tujuan_id' => $pindahGudang->gudang_tujuan_id,
                'tanggal_pemindahan' => $pindahGudang->tanggal_pemindahan,
                'tanggal_penyelesaian' => $tanggalPenyelesaian,
                'nomor_surat_jalan' => $pindahGudang->nomor_surat_jalan,
                'jenis_pindah_gudang' => PindahGudang::PINDAH_MASUK,
                'surat_jalan_file' => $pindahGudang->surat_jalan_file,
            ]);

            $listBarang = $pindahGudang->riwayatStok;
            foreach ($listBarang as $riwayatStok)
            {
                // cek apakah barang dengan nama dan kemasan yang sama sudah ada
                /** @var Barang $barangTujuan */
                $barangAsal = $riwayatStok->barang;
                $barang = Barang::where('gudang_id', $pindahGudang->gudang_tujuan_id)
                    ->where('nama', $barangAsal->nama)
                    ->where('kemasan', $barangAsal->kemasan);

                if (!$barang->exists())
                    Barang::create([
                        'kode_barang' => $barangService->generateKodeBarang($pindahGudang->gudangTujuan),
                        'gudang_id' => $pindahGudang->gudang_tujuan_id,
                        'nama' => $barangAsal->nama,
                        'kemasan' => $barangAsal->kemasan,
                        'jumlah_dus' => 0,
                        'jumlah_kotak' => 0,
                        'jumlah_satuan' => 0,
                        'satuan_per_dus' => $barangAsal->satuan_per_dus,
                        'satuan_per_kotak' => $barangAsal->satuan_per_kotak,
                        'harga' => $barangAsal->harga,
                    ]);

                $barangTujuan = $barang->first();

                // catat riwayat stok barang masuk
                RiwayatStok::create([
                    'stokable_id' => $pindahGudangMasuk->id,
                    'stokable_type' => PindahGudang::class,
                    'barang_id' => $barangTujuan->id,
                    'jumlah_dus' => $riwayatStok->jumlah_dus,
                    'jumlah_satuan' => $riwayatStok->jumlah_satuan,
                    'jumlah_kotak' => $riwayatStok->jumlah_kotak,
                ]);

                // tambahkan stok barang
                $barangTujuan->tambahStok(
                    jumlahDus: $riwayatStok->jumlah_dus,
                    jumlahKotak: $riwayatStok->jumlah_kotak,
                    jumlahSatuan: $riwayatStok->jumlah_satuan
                );

            }

            return $pindahGudangMasuk;
        });
    }

    private function cekStatusJumlahPOdanDO($po, $do, Barang $barang): bool
    {
        return $po[$barang->id]['jumlah_dus'] != ($do[$barang->id]['jumlah_dus'])
            || $po[$barang->id]['jumlah_kotak'] != $do[$barang->id]['jumlah_kotak']
            || $po[$barang->id]['jumlah_satuan'] != $do[$barang->id]['jumlah_satuan'];
    }
}