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
        ['Medicamentos', 'Kg'],
        ['Reciclables', 'Kg'],
        ['Colillas cigarro', 'Kg'],
        ['Mezclilla', 'Kg'],
        ['Aceite de cocina', 'L'],
        ['Pilas', 'Kg'],
        ['Toners', 'Kg'],
        ['Botellas De Pet', 'Kg'],
        ['Bolsas Plasticas', 'Kg'],
        ['Envases Plasticos', 'Kg'],
        ['Tapas Y Tapa Plasticas', 'Kg'],
        ['Envases De Poliestireno', 'Kg'],
        ['Periodicos', 'Kg'],
        ['Revistas', 'Kg'],
        ['Folletos', 'Kg'],
        ['Carton', 'Kg'],
        ['Papel De Oficina Usado', 'Kg'],
        ['Latas De Aluminio', 'Kg'],
        ['Latas De Acero', 'Kg'],
        ['Alambre Y Cables Metalicos', 'Kg'],
        ['Chatarra Metalica', 'Kg'],
        ['Botellas De Vidrio', 'Kg'],
        ['Frascos Y Envases De Vidrio', 'Kg'],
        ['Vidrio Plano', 'Kg'],
        ['Sabanas Y Toallas', 'Kg'],
        ['Ropa Textil Para Reciclaje', 'Kg'],
        ['Carton No Tratado', 'Kg'],
        ['Maderas De Muebles', 'Kg'],
        ['Restos De Ladrillos Y Bloques', 'Kg'],
        ['Placas De Yeso', 'Kg'],
        ['Retazos De Tela', 'Kg'],
        ['Materiales Usados En Industria', 'Kg'],
        // Added liquid wastes
        ['Solventes Químicos', 'L'],
        ['Aceites Automotrices', 'L'],
        ['Pinturas Líquidas', 'L'],
        ['Residuos de Combustibles', 'L'],
        ['Líquidos de Limpieza', 'L'],
        ['Líquidos Refrigerantes', 'L'],
        ['Aguas Residuales', 'L'],
    ];    
}
