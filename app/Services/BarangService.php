<?php

namespace App\Services;

use App\Http\Requests\CreateBarangRequest;
use App\Models\Barang;
use App\Models\Gudang;

class BarangService
{
    const PREFIX_KODE_BARANG = 'BBT';

    public function tambahBarangBaru(Gudang $gudang, CreateBarangRequest $request): bool
    {
        $data = $request->validated();

        $listBarang = [];
        $nomorBarangTerakhir = $this->getNomorBarangTerakhir($gudang);
        foreach ($data['kemasan'] as $barang)
        {
            $listBarang[] = [
                'kemasan' => $barang['varian'],
                'harga' => $barang['harga'],
                'nama' => $data['nama'],
                'satuan' => $data['satuan'],
                'gudang_id' => $gudang->id,
                'satuan_per_dus' => $barang['satuan_per_dus'],
                'satuan_per_kotak' => $barang['satuan_per_kotak'],
                'kode_barang' => $this->generateKodeBarang($gudang, $nomorBarangTerakhir++)
            ];
        }

        return Barang::insert($listBarang);
    }

    public function tambahStokBarang(
        Barang $barang,
        int $jumlahDus,
        int $jumlahKotak,
        int $jumlahSatuan
    ): Barang {
        // jumlah dus = jumlah dus masuk + jumlah dus yang ada
        $barang->jumlah_kotak += $jumlahKotak;

        // jumlah kotak = jumlah kotak masuk + jumlah kotak yang ada
        $barang->jumlah_dus += $jumlahDus;

        // jumlah pcs = (dus * pcs per dus) + (kotak * pcs per kotak) + jumlah pcs yang ada
        $pcsMasuk = $jumlahDus * $barang->satuan_per_dus + $jumlahKotak * $barang->satuan_per_kotak;
        $barang->jumlah_satuan += $pcsMasuk + $jumlahSatuan;

        $barang->save();
        return $barang;
    }

    public function kurangiStok(
        Barang $barang,
        int $jumlahDus,
        int $jumlahKotak,
        int $jumlahSatuan = 0
    ): false|Barang {
        $pcsKeluar = $jumlahDus * $barang->satuan_per_dus + $jumlahKotak * $barang->satuan_per_kotak + $jumlahSatuan;
        if ($pcsKeluar > $barang->jumlah_satuan)
            return false;

        $barang->jumlah_dus -= $jumlahDus;
        $barang->jumlah_kotak -= $jumlahKotak;

        $barang->jumlah_satuan -= $pcsKeluar;
        $barang->save();

        return $barang;
    }

    public function generateKodeBarang(Gudang $gudang, $start = 0): string
    {
        $start = $start < 1 ? $this->getNomorBarangTerakhir($gudang) : $start;

        return sprintf("%s-%s-%03d", $gudang->kode_gudang, self::PREFIX_KODE_BARANG, $start);
    }

    private function getNomorBarangTerakhir(Gudang $gudang): string
    {
        return Barang::where('gudang_id', $gudang->id)->count() + 1;
    }
}