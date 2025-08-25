<?php

namespace Database\Factories\Pivots;

use App\Enums\ChemicalState;
use App\Enums\Condition;
use App\Enums\CRETIB;
use App\Enums\Movement;
use App\Enums\Status;
use App\Enums\Units;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivots\ReagentMovement>
 */
class ReagentMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $state = fake()->randomElement(ChemicalState::cases());
        return [
            'status' => Status::In_Progress,
            'chemical_state' => $state,
            'quantity' => fake()->randomNumber(3). '.' .fake()->randomNumber(3),
            'unit' => fake()->randomElement(Units::options($state)),
        ];
    }

    public function donation(): Factory
    {
        return $this->state(function ($attrs) {
            return [
                'type' => Movement::Donation,
                'photo_url' => fake()->imageUrl(),
                'container' => fake()->word(),
                'weight' => fake()->randomFloat(),
                'expiration' => now()->addDays(rand(10, 14)),
                'condition' => fake()->randomElement(Condition::cases()),
                'proc_fac' => fake()->word(),
                'proc_lab' => 'LAB ' . fake()->bothify('###'),
                'cretib' => fake()->randomElements(CRETIB::cases(), rand(0, count(CRETIB::cases()) - 1)),
            ];
        });
    }

    public function petition($name = null): Factory
    {
        return $this->state(function ($attrs) use ($name) {
            $data = [
                'comment' => fake()->sentences(asText: true),
                'type' => Movement::Petition
            ];

            if($name) {
                $data['type'] = Movement::Petition_By_Name;
                $data['reagent_name'] = fake()->word();
            }
            
            return $data;
        });
    }
}
