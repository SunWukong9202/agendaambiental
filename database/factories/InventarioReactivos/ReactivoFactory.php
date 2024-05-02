<?php

namespace Database\Factories\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventarioReactivos\Reactivo>
 */
class ReactivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('es_ES');

        return [
            'nombre' => $faker->word,
            'grupo' => $faker->word,
            'formula' => $faker->word,
            'unidad' => $faker->word,
            'visible' => $faker->boolean,
            'total' => 0.00,
        ];
    }

    public function visible(): Factory
    {
        return $this->state(function (array $attributes): array {
           return [
            'visible' => true
           ]; 
        });
    }
}
