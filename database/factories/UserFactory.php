<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        $nivel = ['Nivel Medio Superior', 'Licenciatura', 'Maestria', 'Doctorado', 'Otro'];
        return [
            'clave' => ''.fake()->unique()->numberBetween(100000, 999999),
            'name' => $f->firstName(),
            'ap_pat' => $f->lastName(),
            'ap_mat' => $f->lastName(),
            'facultad' => $this->facultades[rand(0, count($this->facultades) - 1)],
            'nivel_academico' => $nivel[rand(0, count($nivel) - 1)],
            'telefono' => $f->numerify('(444) ### ####'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

public $facultades = 
[
    'Agronomía y Veterinaria',
    'Ciencias',
    'Ciencias de la Comunicación',
    'Ciencias de la Información',
    'Ciencias Químicas',
    'Ciencias Sociales y Humanidades',
    'Contaduría y Administración',
    'Derecho Abogado Ponciano Arriaga Leija',
    'Economía',
    'Enfermería y Nutrición',
    'Estomatología',
    'Hábitat',
    'Ingeniería',
    'Medicina',
    'Psicología',
];
}
