<?php

namespace Database\Factories\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventarioReactivos\CapturaReactivo>
 */
class CapturaReactivoFactory extends Factory
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
            'foto' => $faker->imageUrl(),
            'envase' => $faker->word,
            'peso' => $faker->randomFloat(2, 0, 999.99),
            'cantidad' => $faker->randomFloat(2, 0, 9999.99),
            'estado' => $faker->randomElement(['solido', 'liquido', 'gaseoso']),
            'caducidad' => $faker->dateTime(),
            'condicion' => $faker->randomElement(['nuevo', 'seminuevo', 'usado']),
            'facultad_procedencia' => $faker->word,
            'laboratorio_procedencia' => $faker->word,
            'CRETIB' => $faker->word,
        ];
    }
}
