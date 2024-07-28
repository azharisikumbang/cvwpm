<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gudang>
 */
class GudangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_gudang' => strtoupper($this->faker->unique()->word()),
            'nama' => $this->faker->unique()->word(),
            'lokasi' => $this->faker->optional()->word(),
        ];
    }
}
