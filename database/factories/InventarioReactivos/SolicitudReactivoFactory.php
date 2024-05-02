<?php

namespace Database\Factories\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventarioReactivos\SolicitudReactivo>
 */
class SolicitudReactivoFactory extends Factory
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
            'cantidad' => $faker->randomFloat(2, 0, 0499.99),
            'observaciones' => $faker->sentence,
            'estado' => $faker->boolean(),
        ];
    }
}
