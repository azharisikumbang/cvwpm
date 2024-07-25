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
            ['nama' => 'Gudang Padang', 'lokasi' => 'Padang'],
            ['nama' => 'Gudang Solok', 'lokasi' => 'Solok'],
            ['nama' => 'Gudang Dharmasraya', 'lokasi' => 'Dharmasraya'],
        ]);
    }
}
