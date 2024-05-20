<?php

namespace Database\Factories\InventarioAcopio;

use App\Models\InventarioAcopio\Articulo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticuloFactory extends Factory
{

    protected $model= Articulo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('es_ES');

        return [
            'nombre' => $faker->name,
            'cantidad' => rand(0, 10)
        ];
    }
}

