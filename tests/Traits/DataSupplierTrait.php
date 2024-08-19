<?php

namespace Tests\Traits;

use App\Models\Gudang;
use App\Models\Staf;

trait DataSupplierTrait
{
    public function createGudang()
    {
        Gudang::factory()->createMany([
            [
                'kode_gudang' => 'PDG',
                'lokasi' => 'Padang',
                'nama' => 'Gudang Padang'
            ],
            [
                'kode_gudang' => 'SLK',
                'lokasi' => 'Solok',
                'nama' => 'Gudang Solok'
            ],
            [
                'kode_gudang' => 'DMS',
                'lokasi' => 'Dharmasraya',
                'nama' => 'Gudang Dharmasraya'
            ]
        ]);
    }

    public function createStaf(int $idGudang, int $userId)
    {
        Staf::factory()->create([
            'jabatan' => 'Admin Stock',
            'user_id' => $userId,
            'gudang_kerja' => $idGudang
        ]);
    }
}
