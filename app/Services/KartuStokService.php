<?php

namespace App\Services;

use App\Http\Requests\ShowKartuStokRequest;
use App\Models\Barang;
use App\Models\DeliveryOrder;
use App\Models\Penjualan;
use App\Models\PindahGudang;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use DateTimeInterface;
use DateTime;

class KartuStokService
{
    public function getKartuStok(
        Barang $barang,
        DateTimeInterface $awal,
        ?DateTimeInterface $akhir = null
    ): array {
        $timestamp = $this->addMinAndMaxTime($awal, $akhir ?? new DateTime());

        $barang = Barang::where('id', $barang->id)
            ->with([
                'gudang',
                'riwayatStok' => function ($query) use ($timestamp) {
                    $query->whereIn('stokable_type', [
                        DeliveryOrder::class,
                            // SalesCanvas::class,
                        Penjualan::class,
                        PindahGudang::class
                    ]);

                    return $query->whereBetween('created_at', $timestamp);
                },
            ])
            ->first();

        return $this->formatToViewData($barang);
    }

    public function createFromRequest(ShowKartuStokRequest $request): array
    {
        return $this->getKartuStok(
            Barang::find($request->barang),
            new DateTime($request->awal),
            $request->akhir ? new DateTime($request->akhir) : null
        );
    }

    private function addMinAndMaxTime(DateTime $start, DateTime $end): array
    {
        return [
            $start->setTime(0, 0)->format('Y-m-d H:i:s'),
            $end->setTime(23, 59)->format('Y-m-d H:i:s'),
        ];
    }

    private function formatToViewData(Barang $barang)
    {

        $totalMasuk = 0;
        $totalKeluar = 0;
        $totalSisa = 0;
        $listRiwayatStok = [];

        $riwayatStok = $barang->riwayatStok;
        foreach ($riwayatStok as $stok)
        {
            $masuk = 0;
            $keluar = 0;

            switch ($stok->tipe_riwayat)
            {
                case RiwayatStok::BARANG_MASUK:
                    $masuk = $stok->total_pcs;
                    $totalSisa += $stok->total_pcs;
                    break;
                case RiwayatStok::BARANG_KELUAR;
                    $keluar = $stok->total_pcs;
                    $totalSisa -= $stok->total_pcs;
                    break;
            }

            $totalMasuk += $masuk;
            $totalKeluar += $keluar;

            $listRiwayatStok[] = [
                'tanggal' => format_tanggal_indonesia($stok->created_at),
                'keterangan' => $stok->keterangan,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'sisa' => $totalSisa
            ];
        }

        return [
            'barang' => $barang->only('nama_kemasan'),
            'gudang' => [
                'kode_gudang' => $barang->gudang->nama,
                'nama' => $barang->gudang->kode_gudang,
            ],
            'riwayat_stok' => $listRiwayatStok,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'total_sisa' => $totalSisa
        ];
    }
}