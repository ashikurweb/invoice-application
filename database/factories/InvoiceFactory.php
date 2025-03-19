<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id'         => Customer::factory(), 
            'number'              => $this->faker->unique()->numerify('INV-#####'),
            'date'                => $this->faker->date(),
            'due_date'            => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'reference'           => $this->faker->bothify('REF-####??'),
            'terms_and_conditions'=> $this->faker->sentence(),
            'sub_total'           => $this->faker->randomFloat(2, 500, 5000),
            'discount'            => $this->faker->randomFloat(2, 10, 500),
            'total'               => fn ($attributes) => $attributes['sub_total'] - $attributes['discount'],
        ];
    }
}
