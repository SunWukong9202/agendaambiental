<?php

namespace Database\Factories\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;

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
        $base = [
            'cantidad' => $faker->randomFloat(2, 0, 0499.99),
            'comentario' => $faker->text(250),
            'estado' => $faker->boolean(),
        ];

        return $base; 
    }

    protected function randomOf($arr) 
    {
        $result = $arr[rand(0, count($arr) - 1)];
        return $result;
    }
}
