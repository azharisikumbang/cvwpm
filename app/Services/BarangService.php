<?php

namespace App\Services;

use App\Http\Requests\CreateBarangRequest;
use App\Models\Barang;
use App\Models\Gudang;

class BarangService
{
    public function tambahBarangBaru(Gudang $gudang, CreateBarangRequest $request): bool
    {
        $data = $request->validated();

        $listBarang = [];
        foreach ($data['kemasan'] as $barang)
        {
            $listBarang[] = [
                'kemasan' => $barang['varian'],
                'harga' => $barang['harga'],
                'nama' => $data['nama'],
                'satuan' => $data['satuan'],
                'gudang_id' => $gudang->id
            ];
        }

        return Barang::insert($listBarang);
    }
}