<?php

namespace Database\Factories;

use App\Enums\Units;
use App\Models\CMUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reagent>
 */
class ReagentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'group' => fake()->word,
            'chemical_formula' => fake()->word,
            'visible' => fake()->boolean(),
        ];
    }

    public function withUser(CMUser $user)
    {
        return $this->state(fn () => [
            'cm_user_id' => $user->id
        ]);
    }

    const preloaded = [

        [
            'name' => 'Ácido Sulfúrico',
            'group' => 'Ácido',
            'chemical_formula' => 'H₂SO₄',
        ],
        [
            'name' => 'Hidróxido de Sodio',
            'group' => 'Base',
            'chemical_formula' => 'NaOH',
        ],
        [
            'name' => 'Cloruro de Sodio',
            'group' => 'Sal',
            'chemical_formula' => 'NaCl',
        ],
        [
            'name' => 'Ácido Clorhídrico',
            'group' => 'Ácido',
            'chemical_formula' => 'HCl',
        ],
        [
            'name' => 'Peróxido de Hidrógeno',
            'group' => 'Oxidante',
            'chemical_formula' => 'H₂O₂',
        ],
        [
            'name' => 'Ácido Nítrico',
            'group' => 'Ácido',
            'chemical_formula' => 'HNO₃',
        ],
        [
            'name' => 'Carbonato de Calcio',
            'group' => 'Sal',
            'chemical_formula' => 'CaCO₃',
        ],
        [
            'name' => 'Sulfato de Cobre',
            'group' => 'Sal',
            'chemical_formula' => 'CuSO₄',
        ],
        [
            'name' => 'Hidróxido de Amonio',
            'group' => 'Base',
            'chemical_formula' => 'NH₄OH',
        ],
        [
            'name' => 'Ácido Acético',
            'group' => 'Ácido',
            'chemical_formula' => 'CH₃COOH',
        ],
        
        [
            'name' => 'Ácido Clorhídrico',
            'group' => 'Ácido',
            'chemical_formula' => 'HCl',
        ],
        [
            'name' => 'Sulfato de Aluminio',
            'group' => 'Sal',
            'chemical_formula' => 'Al₂(SO₄)₃',
        ],
        [
            'name' => 'Hidróxido de Potasio',
            'group' => 'Base',
            'chemical_formula' => 'KOH',
        ],
        [
            'name' => 'Ácido Fosfórico',
            'group' => 'Ácido',
            'chemical_formula' => 'H₃PO₄',
        ],
        [
            'name' => 'Cloruro de Potasio',
            'group' => 'Sal',
            'chemical_formula' => 'KCl',
        ],
        [
            'name' => 'Ácido Sulfhídrico',
            'group' => 'Ácido',
            'chemical_formula' => 'H₂S',
        ],
        [
            'name' => 'Nitrato de Amonio',
            'group' => 'Sal',
            'chemical_formula' => 'NH₄NO₃',
        ],
        [
            'name' => 'Hipoclorito de Sodio',
            'group' => 'Oxidante',
            'chemical_formula' => 'NaClO',
        ],
        [
            'name' => 'Ácido Bórico',
            'group' => 'Ácido',
            'chemical_formula' => 'H₃BO₃',
        ],
        [
            'name' => 'Carbonato de Sodio',
            'group' => 'Sal',
            'chemical_formula' => 'Na₂CO₃',
        ],
    ];
}
