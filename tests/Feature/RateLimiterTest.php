<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\CMUser;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RateLimiterTest extends TestCase
{
    private const LIMIT = 30;

    public function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('web');
    }

    /** @test */
    public function login_blocks_after_limit_is_exceded()
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->get('/');
            $response->assertStatus(200);
        }
        $response = $this->get('/');
        $response->assertStatus(429);
    }

    /** @test */
    public function client_routes_block_requests_after_limit_is_exceeded()
    {
        $client = User::factory()->create();
    
        $this->actingAs($client);

        for ($i = 0; $i < self::LIMIT; $i++) {
            $this->get('/home');
        }

        $response = $this->get('/home');
        $response->assertStatus(429); // Too Many Requests
    }

    /** @test */
    public function admin_routes_block_requests_after_limit_is_exceeded()
    {
        $admin = User::factory()->create();

        $admin = CMUser::factory()->create([
            'user_id' => $admin->id
        ]);

        $admin->assignRole(Role::Admin);

        $this->actingAs($admin->user);

        for ($i = 0; $i < self::LIMIT; $i++) {
            $this->get('/admin');
        }

        $response = $this->get('/admin');
        $response->assertStatus(429); // Too Many Requests
    }
}
