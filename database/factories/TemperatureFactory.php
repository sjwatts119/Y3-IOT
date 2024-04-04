<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Temperature>
 */
class TemperatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //we need to make sure the temperature is between 0 and 30 degrees.
            'sensor1' => $this->faker->randomFloat(1, 0, 30),
            'sensor2' => $this->faker->randomFloat(1, 0, 30),
        ];
    }
}
