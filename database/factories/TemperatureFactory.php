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
            'sensorInside' => $this->faker->randomFloat(1, 15, 22),
            'sensorOutside' => $this->faker->randomFloat(1, 0, 15),
        ];
    }
}
