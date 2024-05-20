<?php

namespace Database\Factories\Acopio;

use App\Models\Acopio\Donacion;
use App\Models\Acopio\DonacionPorCategoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acopio\Donacion>
 */
class DonacionFactory extends Factory
{
    protected $model = Donacion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('es_ES');

        $de_residuos = $faker->boolean();
        $donados = null;
        $tomados = null;

        if(!$de_residuos) {
            $donados = rand(0, 7);
            $tomados = rand(0, 5);
        }
        return compact(
            'donados',
            'tomados', 
            'de_residuos'
        );
    }
}

