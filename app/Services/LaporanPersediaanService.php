<?php

namespace App\Services;

use App\Http\Requests\CreateLaporanPersediaanRequest;
use App\Models\Gudang;

class LaporanPersediaanService
{
    public function getListGudang(): array
    {
        $gudang = Gudang::all(['id', 'kode_gudang', 'nama', 'lokasi'])->toArray();

        return $gudang;
    }

    public function createFromRequest(CreateLaporanPersediaanRequest $request): array
    {
        return $this->getData(
            Gudang::find($request->gudang),
            $request->year,
            $request->month
        );
    }

    public function getData(
        Gudang $gudang,
        ?int $year,
        ?int $month
    ): array {

        $periode = format_bulan_indo($month ?? date('n')) . ' ' . ($year ?? date('Y'));

        $result = [
            'gudang' => $gudang->only('kode_gudang', 'nama', 'lokasi'),
            'periode' => $periode,
            'barang' => []
        ];

        $result['barang'] = $gudang
            ->barang()
            ->orderBy('kode_barang')
            ->get()
            ->select('kode_barang', 'nama_kemasan', 'jumlah_satuan', 'harga', 'satuan', 'harga_rupiah')
            ->toArray();

        return $result;
    }

    public function getFileLaporan(
        Gudang $gudang,
        int $year,
        int $month
    ): string {
        // check if file already created and return the path
        $path = FileAssetService::findFileLaporanPersediaan($gudang, $year, $month);

        if (file_exists($path))
            return $path;

        // store history to database and lock it

        // create and store file

        // return path

        return $path;
    }
}
