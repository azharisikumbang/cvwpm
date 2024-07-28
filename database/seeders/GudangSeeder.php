<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gudang::factory()->createMany([
            ['nama' => 'Gudang Padang', 'lokasi' => 'Padang', 'kode_gudang' => 'PDG'],
            ['nama' => 'Gudang Solok', 'lokasi' => 'Solok', 'kode_gudang' => 'SLK'],
            ['nama' => 'Gudang Dharmasraya', 'lokasi' => 'Dharmasraya', 'kode_gudang' => 'DSR'],
        ]);
    }
}
