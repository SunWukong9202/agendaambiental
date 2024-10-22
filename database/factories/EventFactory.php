<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;

class EventFactory extends Factory
{

    protected $model = Event::class;

    public $eventosAcopioResiduos = [
        "Recogida de Residuos Electrónicos: Deshazte Responsablemente de tus Dispositivos",
        "Operación Reciclaje: Transforma tus Residuos en Recursos",
        "Jornada de Recogida de Pilas: Cuida el Medio Ambiente, Recicla tus Pilas",
        "Campaña de Acopio de Papel: Reduciendo el Desperdicio, Salvando los Bosques",
        "Recogida de Residuos Peligrosos: Manejo Seguro para un Mundo Saludable",
        "Evento de Reciclaje de Vidrio: Transforma tus Envases en Nuevas Oportunidades",
        "Día de la Recogida de Plásticos: Un Paso hacia un Océano Libre de Plástico",
        "Jornada de Recolección de Residuos Orgánicos: Fomentando el Compostaje",
        "Campaña de Acopio de Aceite Usado: Cuida tu Hogar y el Planeta",
        "Recogida de Ropa Vieja: Dale una Segunda Vida a tus Prendas"
    ];

    public $eventosMedioAmbiente = [
        "Día del Árbol: Plantación Masiva",
        "Limpieza Costera: Salvemos Nuestros Océanos",
        "Rally Ecológico: Recorriendo Nuestra Naturaleza",
        "Caminata Verde: Explorando Senderos Sostenibles",
        "Fiesta de la Biodiversidad: Celebrando la Vida Silvestre",
        "Charla Ambiental: Educación para la Sostenibilidad",
        "Feria del Agua: Promoviendo el Uso Responsable del Agua",
        "Proyecto Renacer: Restauración de Ecosistemas",
        "Campaña de Reciclaje: Reduciendo, Reutilizando, Reciclando",
        "Semana del Medio Ambiente: Actuando por un Futuro Sostenible"
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('es_ES');

        return [
            'name' => $faker->randomElement($this->eventosAcopioResiduos),
            'description' => substr($faker->paragraph(), 0, 255),
            'faculty' => $faker->randomElement(Config::get('opciones.facultades')),
            'start' => now(),
            'end' => now()->addDays(rand(1,3)),
        ];
    }
}
