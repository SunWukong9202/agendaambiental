<?php

namespace Database\Factories\InventarioReactivos;

use App\Enums\Condicion;
use App\Enums\CRETIB;
use App\Enums\Estado;
use App\Models\InventarioReactivos\DonacionReactivo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventarioReactivos\DonacionReactivo>
 */
class DonacionReactivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('es_ES');
        $envases = Config::get('opciones.envase');
        $cantidad = $faker->randomFloat(2, 0, 0999.99);
        $estado = $this->randomOf(Estado::cases());
        $condicion = $this->randomOf(Condicion::cases());
        $cretib = $faker->randomElements(CRETIB::cases(), rand(0, count(CRETIB::cases())));
        // Define el rango de fechas
        $startDate = 'now'; // Hoy
        $endDate = '+1 month'; // Un mes en el futuro
        $randomDate = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i:s');
        return [
            'foto' => null,
            'envase' => $this->randomOf($envases),
            'peso' => $cantidad + 3,
            'cantidad' => $cantidad,
            'estado' => $estado,
            'caducidad' => $randomDate,
            'condicion' => $condicion,
            'fac_proc' => $this->randomOf(Config::get('opciones.facultades')),
            'lab_proc' => "LAB " . $faker->bothify('###'),
            'CRETIB' => $cretib,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (DonacionReactivo $captura) {

        })->afterCreating(function (DonacionReactivo $captura) {
            // ...
            $cretib = \Faker\Factory::create()->randomElements(CRETIB::cases(), rand(0, count(CRETIB::cases())));
            $captura->CRETIB = $cretib;
            $captura->save();
        });
    }

    protected function randomOf($arr) 
    {
        $result = $arr[rand(0, count($arr) - 1)];
        return $result;
    }
}
