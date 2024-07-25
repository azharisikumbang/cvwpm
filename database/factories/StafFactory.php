<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staf>
 */
class StafFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->jobTitle(),
            'kontak' => $this->faker->phoneNumber(),
            'gudang_kerja' => \App\Models\Gudang::factory()
        ];
    }
}
