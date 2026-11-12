<?php

namespace Database\Factories;

use App\Models\ShipmentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShipmentModel>
 */
class ShipmentModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(3),
            'from_city'    => fake()->city(),
            'from_country' => fake()->country(),
            'to_city'      => fake()->city(),
            'to_country'   => fake()->country(),
            'price'        => fake()->randomFloat(2, 50, 5000),
            'status'       => fake()->randomElement(['in_progress', 'unassigned', 'completed', 'problem']),
            'user_id'      => User::factory(),
            'details'      => fake()->paragraph(),
        ];
    }
}
