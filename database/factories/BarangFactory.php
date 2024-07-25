<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word,
            'kemasan' => $this->faker->randomElement(['10gr', '20gr', '40gr', '40gr', '50gr', '100gr', '200gr', '500gr', '1kg', '5kg', '10kg', '20kg', '25kg', '50kg', '100kg', '200kg', '500kg', '1ton']),
            'harga' => $this->faker->randomFloat(2, 1000, 100_000),
            'satuan' => $this->faker->randomElement(['pcs', 'kg', 'gr', 'ml', 'lt']),
            'jumlah_dus' => 0,
            'jumlah_satuan' => 0,
            'jumlah_kotak' => 0,
        ];
    }
}
