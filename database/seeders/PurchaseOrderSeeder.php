<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\PurchaseOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listGudang = Gudang::all();
        if ($listGudang)
        {
            foreach ($listGudang as $gudang)
            {
                $gudang->load('penanggungJawab');
                PurchaseOrder::factory()->create(['gudang_id' => $gudang->id, 'staf_id' => $gudang->penanggungJawab->id]);
            }
        }
    }
}
