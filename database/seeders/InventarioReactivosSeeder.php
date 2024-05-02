<?php

namespace Database\Seeders;

use App\Models\InventarioReactivos\Reactivo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class InventarioReactivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataset = new Collection(Config::get('reactivos'));

        $reactivos = $dataset->map(function ($reactivo) {
            return Reactivo::factory()->create($reactivo);
        });

        // $user = User::factory()
        //     ->count(10)
        //     ->hasAttached(
        //         $reactivos, 
        //         [
        //             'foto'
        //         ]
        //     )

    }
}
