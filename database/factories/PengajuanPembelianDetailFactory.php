<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengajuanPembelianDetail>
 */
class PengajuanPembelianDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jumlah_kotak' => fake()->numberBetween(1, 20),
            'jumlah_dus' => fake()->numberBetween(1, 20),
        ];
    }
}
