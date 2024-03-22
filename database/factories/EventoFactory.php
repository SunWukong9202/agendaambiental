<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $f = Faker::create('es_ES');
        $horarios = ['13:00 - 14:00', '10:00 - 12:00', '14:00 - 16:00', '16:00 - 17:00'];
        return [
            'name' => $f->sentence(2),
            'inscripciones' => $f->sentence(6),
            'objetivo' => $f->sentence(6),
            'prerequisitos' => $f->sentence(6),
            'lugar' => $f->city(),
            'url' => $f->url(),
            'ubicacion' => $f->address(),
            'horario' => $horarios[rand(0, count($horarios) - 1)],
        ];
    }
}
