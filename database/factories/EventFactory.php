<?php

namespace Database\Factories;

use App\Models\CMUser;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;

class EventFactory extends Factory
{

    protected $model = Event::class;

    public $eventosAcopioResiduos = [
        'recogidaDeResiduosElectronicos' => 'Recogida de Residuos Electrónicos: Deshazte Responsablemente de tus Dispositivos',
        'operacionReciclaje' => 'Operación Reciclaje: Transforma tus Residuos en Recursos',
        'jornadaDeRecogidaDePilas' => 'Jornada de Recogida de Pilas: Cuida el Medio Ambiente, Recicla tus Pilas',
        'campañaDeAcopioDePapel' => 'Campaña de Acopio de Papel: Reduciendo el Desperdicio, Salvando los Bosques',
        'recogidaDeResiduosPeligrosos' => 'Recogida de Residuos Peligrosos: Manejo Seguro para un Mundo Saludable',
        'eventoDeReciclajeDeVidrio' => 'Evento de Reciclaje de Vidrio: Transforma tus Envases en Nuevas Oportunidades',
        'diaDeLaRecogidaDePlasticos' => 'Día de la Recogida de Plásticos: Un Paso hacia un Océano Libre de Plástico',
        'jornadaDeRecoleccionDeResiduosOrganicos' => 'Jornada de Recolección de Residuos Orgánicos: Fomentando el Compostaje',
        'campañaDeAcopioDeAceiteUsado' => 'Campaña de Acopio de Aceite Usado: Cuida tu Hogar y el Planeta',
        'recogidaDeRopaVieja' => 'Recogida de Ropa Vieja: Dale una Segunda Vida a tus Prendas',
    ];
    
    public $descripciones = [
        'recogidaDeResiduosElectronicos' => 'Recoge tus dispositivos electrónicos viejos y deséchalos de manera responsable. Evita la contaminación y promueve el reciclaje de materiales valiosos.',
        'operacionReciclaje' => 'Contribuye al reciclaje transformando tus residuos en recursos. Ayuda a reducir el desperdicio y favorece la reutilización de materiales.',
        'jornadaDeRecogidaDePilas' => 'Las pilas y baterías usadas no deben ir a la basura común. Trae las tuyas para reciclarlas de manera segura y proteger el medio ambiente.',
        'campañaDeAcopioDePapel' => 'Recicla tus periódicos, revistas y otros papeles para reducir el desperdicio, contribuir a la conservación de los bosques y fomentar el reciclaje.',
        'recogidaDeResiduosPeligrosos' => 'Participa en este evento para el manejo seguro de residuos peligrosos como productos químicos o materiales contaminantes que requieren un tratamiento especial.',
        'eventoDeReciclajeDeVidrio' => 'Recoge y recicla tus botellas y frascos de vidrio. Ayuda a reducir la contaminación y fomenta la creación de nuevos productos a partir de materiales reciclados.',
        'diaDeLaRecogidaDePlasticos' => 'Lleva tus plásticos reciclables para reducir el impacto en nuestros océanos. Trabajemos juntos para crear un futuro libre de plásticos.',
        'jornadaDeRecoleccionDeResiduosOrganicos' => 'Recoge y recicla tus residuos orgánicos para promover el compostaje y crear abono natural que favorezca el medio ambiente.',
        'campañaDeAcopioDeAceiteUsado' => 'Recicla el aceite usado de cocina de manera segura. Este aceite puede contaminar el agua, pero puede ser reciclado y reutilizado para otros fines.',
        'recogidaDeRopaVieja' => 'Recoge tu ropa vieja y dona o recicla aquellas prendas que ya no utilizas. Da una segunda vida a la ropa y ayuda a la reducción de residuos textiles.',
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
        $name = fake()->randomElement($this->eventosAcopioResiduos);
        $description = fake()->randomElement($this->descripciones);   
        return [
            'name' => $name,
            'description' => substr($description, 0, 255),
            'faculty' => fake()->randomElement(Config::get('opciones.facultades')),
            'start' => now(),
            'end' => now()->addDays(rand(1,3)),
        ];
    }

    public function withUser(CMUser $user)
    {
        return $this->state(fn () => [
            'cm_user_id' => $user->id
        ]);
    }
}
