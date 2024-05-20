<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
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
        
        // $es_acopio = $this->faker->boolean();
        // $fecha_publicacion = $faker->dateTimeBetween('+1 week', '+2 weeks');
        // $ini_evento = $faker->dateTimeBetween($fecha_publicacion->modify('+1 week'), $fecha_publicacion->modify('+2 weeks'));
        // $nombre = $faker->randomElement($this->eventosAcopioResiduos);
        // $ini_convocatoria = null;
        // $fin_convocatoria = null;

        // if (!$es_acopio) {
        //     $ini_convocatoria = $this->faker->dateTimeBetween($fecha_publicacion->modify('+0 days'), $fecha_publicacion->modify('+7 days'));
        //     $fin_convocatoria = $this->faker->dateTimeBetween($ini_convocatoria->modify('+1 weeks'), $ini_convocatoria->modify('+2 weeks'));
        //     $ini_evento = $fin_convocatoria->modify('+1 day');
        // } 

        // return [
        //     'nombre' => $nombre,
        //     'descripcion' => $faker->paragraph(),
        //     'sede' => $faker->city(),
        //     'cartel' => $faker->imageUrl(),
        //     'fecha_publicacion' => $fecha_publicacion,
        //     'ini_convocatoria' => $ini_convocatoria,
        //     'ini_evento' => $ini_evento,
        //     'fin_convocatoria' => $fin_convocatoria,
        //     'es_acopio' => $es_acopio,
        // ];

        return [
            'nombre' => $faker->randomElement($this->eventosAcopioResiduos),
            'descripcion' => $faker->paragraph(),
            'sede' => $faker->randomElement(Config::get('opciones.facultades')),
            'ini_evento' => $faker->dateTimeBetween(now()),
            'es_acopio' => true,
        ];
    }
}
