<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Event $event;
    private Supplier $supplier;
    private Waste $waste;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->event = Event::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->supplier = Supplier::factory()->create();
        $this->waste = Waste::factory()->create();

        $this->event->suppliers()->attach(
            $this->supplier->id,
            [
                'waste_id' => $this->waste->id,
                'quantity' => 100,
                'user_id' => $this->user->id
            ] 
        );
    }

    public function test_delivery_can_be_assigned(): void
    {
        $this->assertModelExists($this->event->suppliers->first());
    }

    public function test_delivery_can_access_user(): void
    {
        dump($this->event->suppliers()->first()->delivery->user);
        dd($this->event->suppliers()->first()->delivery->waste);
    }
}

