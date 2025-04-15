<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listGudang = Gudang::get();
        if ($listGudang)
        {
            foreach ($listGudang as $gudang)
            {
                Barang::factory(500)->create(['gudang_id' => $gudang->id]);
            }
        }
    }
}
