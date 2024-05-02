<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\CRETIB;
use App\Models\Evento;
use App\Models\InventarioReactivos\CapturaReactivo;
use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $dataset = new Collection(Config::get('reactivos'));

        $reactivos = $dataset->map(function ($reactivo) {
            return Reactivo::factory()->create($reactivo);
        });

        $solicitantes = User::factory()->count(10)->create();

        foreach($solicitantes as $solicitante) {
            foreach($reactivos as $reactivo) {
                $solicitud = SolicitudReactivo::factory()->make();
                if($solicitud->estado) 
                    $reactivo->total -= $solicitud->cantidad;

                $solicitante->reactivosSolicitados()
                    ->attach($reactivo, $solicitud->toArray());
            }   
        }

        $capturistas = User::factory()->count(10)->create();
        foreach ($capturistas as $capturista) {
            foreach ($reactivos as $reactivo) {
                $captura = DonacionReactivo::factory()->make();
                $reactivo->total += $captura->cantidad;
                 
                $capturista->reactivosDonados()
                    ->attach($reactivo, $captura->toArray());
            }
        }

        $reactivos->each(fn($reactivo) => $reactivo->save());

        // $solicitantes = User::factory()
        //     ->count(10)
        //     ->hasAttached(
        //         $reactivos, 
        //         SolicitudReactivo::factory()->make()->toArray(),
        //         'reactivosSolicitados'
        //     )->create();

        // $donadores = User::factory()
        //     ->count(10)
        //     ->hasAttached(
        //         $reactivos,
        //         CapturaReactivo::factory()->make()->toArray(),
        //         'reactivosCapturados'

        //     )->create();

        // $solicitantes = User::factory()
        //     ->count(10)->create();

        // foreach($solicitantes as $user) {

        //     foreach($reactivos as $reactivo) {
        //         $solicitud = SolicitudReactivo::factory()->make([
        //             'user_id' => $user->id,
        //             'reactivo_id' => $reactivo->id
        //         ]);
        //         if($solicitud->estado) 
        //             $reactivo->total -= $solicitud->cantidad;
                     
        //         $user->reactivosSolicitados()
        //         ->attach($reactivo->id, $solicitud->toArray());
        //     }
        // }

        // $donadores = User::factory()
        //     ->count(10)->create();

        // foreach($donadores as $user) {
        //     // foreach($reactivos as $reactivo) {
        //         //donaciones
        //         foreach($reactivos as $reactivo) {
        //             $captura = CapturaReactivo::create(CapturaReactivo::factory()->make([
        //                 'responsable_id' => $user->id,
        //                 'reactivo_id' => $reactivo->id
        //             ])->toArray());
        //             $cretib = \Faker\Factory::create()->randomElements(CRETIB::cases(), rand(0, count(CRETIB::cases())));
        //             $captura->CRETIB = $cretib;
        //             $captura->save();
        //             $reactivo->total += $captura->cantidad;
        //         }
        // }
        // foreach($reactivos as $reactivo) {
        //     $reactivo->save();
        // }
    }
}
