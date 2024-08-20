<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengajuanPembelian>
 */
class PengajuanPembelianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_pengajuan' => $this->faker->numerify('PP###'),
            'tanggal_pengajuan' => $this->faker->date(),
            'status_pengajuan' => 'DRAFT',
        ];
    }
}
