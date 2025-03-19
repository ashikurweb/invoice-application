<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(), 
            'last_name'  => $this->faker->lastName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'phone'     => '+880' . $this->faker->numberBetween(1000000000, 1999999999),
            'address'    => $this->faker->streetAddress() . ', ' . $this->faker->city() . ', ' . $this->faker->state() . ', ' . $this->faker->country(),
        ];
    }
}
