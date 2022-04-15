<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'time' => $this->faker->time(),
            'slot' => $this->faker->numberBetween($min = 0, $max = 20),
            'user_id' => 1,
        ];
    }
}
