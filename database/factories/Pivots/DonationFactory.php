<?php

namespace Database\Factories\Pivots;

use App\Enums\EventDonation;
use App\Models\CMUser;
use App\Models\Pivots\Donation;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivots\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function setDonator(CMUser $user): Factory
    {   
        return $this->state(function () use ($user): array {
            return [
                'donator_id' => $user->id
            ];
        });
    }

    public function setCapturist(CMUser $user): Factory
    {
        return $this->state(function () use ($user): array {
            return [
                'cm_user_id' => $user->id,
            ];
        });
    }

    public function bookDonation(): Factory {
        return $this->state(function ($attrs): array {
            return [
                'type' => EventDonation::Books->value,
                'books_taken' => rand(0, 5),
                'books_donated' => rand(1, 5),
            ];
        });
    }

    public function wasteDonation(Waste $waste): Factory
    {
        return $this->state(function ($attrs) use($waste) : array {
            return [
                'type' =>  EventDonation::Waste->value,
                'quantity' => fake()->randomNumber(3).'.'.fake()->randomNumber(3),
                'waste_id' => $waste->id,
            ];
        });
    }
}
