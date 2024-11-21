<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Waste>
 */
class WasteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => fake()->word(),
            'unit' => 'Kg'
        ];
    }

    const preloaded = [
        //especified by agenda ambiental
        'Medicamentos',
        'Reciclables',	
        'Colillas cigarro',	
        'Mezclilla',
        'Aceite de cocina', 	
        'Pilas',	
        'Toners',
        //added 
        'Botellas De Pet',
        'Bolsas Plasticas',
        'Envases Plasticos',
        'Tapas Y Tapa Plasticas',
        'Envases De Poliestireno',
        'Periodicos',
        'Revistas',
        'Folletos',
        'Carton',
        'Papel De Oficina Usado',
        'Latas De Aluminio',
        'Latas De Acero',
        'Alambre Y Cables Metalicos',
        'Chatarra Metalica',
        'Botellas De Vidrio',
        'Frascos Y Envases De Vidrio',
        'Vidrio Plano',
        'Sabanas Y Toallas',
        'Ropa Textil Para Reciclaje',
        'Carton No Tratado',
        'Maderas De Muebles',
        'Restos De Ladrillos Y Bloques',
        'Placas De Yeso',
        'Retazos De Tela',
        'Materiales Usados En Industria'
    ];    
}
