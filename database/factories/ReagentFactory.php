<?php

namespace Database\Factories;

use App\Enums\Units;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reagent>
 */
class ReagentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'group' => fake()->word,
            'chemical_formula' => fake()->word,
            'unit' => fake()->randomElement(Units::cases()),
            'visible' => fake()->boolean(),
            'stock' => fake()->randomNumber(9).'.'.fake()->randomNumber(3),
        ];
    }
}
