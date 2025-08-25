<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Pivots\Donation;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DonationsTest extends TestCase
{
    use RefreshDatabase;

    private Event $event;
    private User $user;
    private User $capturist;
    private Waste $waste;
    private Donation $bookDonation;
    private Donation $wasteDonation;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create();
        $event = Event::factory()->create([
            'user_id' => $admin->id
        ]);

        $this->user = User::factory()->create();
        $this->capturist = User::factory()->create();

        $this->waste = Waste::factory()->create();

        $this->bookDonation = Donation::factory()
            ->bookDonation()
            ->setCapturist($this->capturist)
            ->make();
        
        $this->wasteDonation = Donation::factory()
            ->wasteDonation($this->waste)
            ->setCapturist($this->capturist)
            ->make();
    }

    public function test_capturist_attach_donations_to_donator(): void
    {
        
    }
}
