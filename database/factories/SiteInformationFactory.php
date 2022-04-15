<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiteInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => "Qlife Family Clinic",
            "address" => "155A Prince Ade Odedina St,<br>Victoria Island 101244,<br>Lagos",
            "user_id" => 1
        ];
    }
}
