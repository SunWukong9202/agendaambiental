<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $f = \Faker\Factory::create('es_ES');
        return [
            'clave' => ''.fake()->unique()->numberBetween(100000, 999999),
            'nombre' => $f->name(),
            'ap_pat' => $f->lastName(),
            'ap_mat' => $f->lastName(),
            'genero' => $this->randomOf(Config::get('opciones.genero')),
            'procedencia' => $this->randomOf(Config::get('opciones.procedencia')),
            'correo' => $f->unique()->email(),
            'telefono' => $f->unique->numerify('(444) ### ####'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    protected function randomOf($arr) 
    {
        $result = $arr[rand(0, count($arr) - 1)];
        return $result;
    }
}
