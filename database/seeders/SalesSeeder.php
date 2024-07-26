<?php

namespace Database\Seeders;

use App\Models\Staf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staf::factory(10)->create([
            'jabatan' => "Sales",
            'gudang_kerja' => 1,
        ]);


        Staf::factory(10)->create([
            'jabatan' => "Sales",
            'gudang_kerja' => 2,
        ]);
    }
}
