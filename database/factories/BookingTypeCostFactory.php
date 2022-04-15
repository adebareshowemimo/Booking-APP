<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingTypeCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'basic_fee' => $this->faker->numberBetween($min = 50, $max = 20000),
            'immunization_fee' => $this->faker->numberBetween($min = 50, $max = 10000),
            'description' => $this->faker->sentence(),
            'user_id' => 1,
        ];
    }
}
