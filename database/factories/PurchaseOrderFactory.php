<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor' => 'PO.' . date('Y') . $this->faker->numberBetween(1, 10000),
            'tanggal' => date('Y-m-d'),
            'status' => PurchaseOrder::STATUS_PENDING,
        ];
    }
}
