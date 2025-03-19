<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_code' => 'PRD-' . strtoupper(Str::random(8)),
            'description' => $this->faker->sentence(10),
            'unit_price' => $this->faker->randomFloat(2, 50, 5000),
        ];
    }
}
