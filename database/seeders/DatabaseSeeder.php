<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->count(1)->create([
            'rol' => 'Admin'
        ]);

        user::factory()->count(5)->create([
            'rol' => 'Becario'
        ]);
        
        User::factory()->count(20)->create([
            'rol' => 'Cliente'
        ]);

        Evento::factory()->count(10)->create();
    }
}
