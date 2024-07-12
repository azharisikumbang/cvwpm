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
            'nama' => $this->faker->unique()->word,
            'harga' => $this->faker->randomFloat(2, 1000, 100000),
            'satuan' => $this->faker->randomElement(['pcs', 'kg', 'gr', 'ml', 'lt']),
        ];
    }
}
