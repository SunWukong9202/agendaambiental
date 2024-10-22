<?php

namespace Database\Factories\Pivots;

use App\Models\Item;
use App\Enums\Movement;
use App\Enums\Status;
use App\Models\Pivots\ItemMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivots\ItemMovement>
 */
class ItemMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Status::In_Progress,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ItemMovement $itemMovement) {
            dump($itemMovement);
            if($itemMovement->type == Movement::Capture && $itemMovement->status == Status::Fixable) {
                $itemMovement->update([
                    'group_id' => $itemMovement->id
                ]);
            } 
        });
    }

    public function movement(Movement $movement): Factory
    {
        return $this->state(function () use ($movement): array {
            return [
                'type' => $movement,
                'status' => fake()->randomElement(Status::by($movement)),  
            ];
        });
    }

    public function setItem(Item $item): Factory
    {
        return $this->state(function ($args) use ($item) {
            return [
                'item_id' => $item->id
            ];
        });
    }

    public function setGroupId(ItemMovement $movement): Factory
    {
        return $this->state(function ($attrs) use ($movement) {
            return [
                'group_id' => $movement->group_id
            ];
        });
    }

    public function setReparator(User $user): Factory
    {
        return $this->state(function ($attrs) use ($user) {
            return [
                'related_id' => $user->id,
            ];
        });
    }

    public function setUser(User $user): Factory
    {
        return $this->state(function ($attrs) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function petition($name = null): Factory
    {
        return $this->state(function () use ($name) {
            $data = [
                'type' => Movement::Petition,
            ];

            if($name) {
                $data['type'] = Movement::Petition_By_Name;
                $data['item_name'] = $name;
            }

            return $data;
        });
    }
}
