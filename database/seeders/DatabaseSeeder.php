<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\CRETIB;
use App\Livewire\Pages\Inventarios\Acopio;
use App\Models\Acopio\AcopioPorCategoria;
use App\Models\Acopio\Donacion;
use App\Models\Acopio\Proveedor;
use App\Models\Acopio\Residuo;
use App\Models\Evento;
use App\Models\InventarioAcopio\Articulo;
use App\Models\InventarioReactivos\CapturaReactivo;
use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Factories\Acopio\ArticuloFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Faker\Factory as Faker;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create('es_ES');

        $catalogo = new Collection(Config::get('catalogos.residuos'));
        $acopio = Evento::factory()->count(1)->create()->first();
        $acopiador = User::factory()->count(1)->create()->first();
        $donadores = User::factory()->count(5)->create();
        $proveedores = Proveedor::factory()->count(15)->create();

        $articulos = Articulo::factory()->count(30)->create();
    
        $residuos = $catalogo->map(function ($residuo) {
            return Residuo::create([
                'categoria' => $residuo,
            ]);
        });

        $acopiosPorCategorias = $residuos->map(function ($residuo) use ($acopio) {
            return AcopioPorCategoria::create([
                'acopio_id' => $acopio->id,
                'residuo_id' => $residuo->id
            ]);
        });

        foreach ($donadores as $donador) {

            $donaciones = Donacion::factory()->count(2)->create([
                'capturista_id' => $acopiador->id,
                'donador_id' => $donador->id,
                'acopio_id' => $acopio->id
            ]);

            foreach ($donaciones as $donacion) {
                if($donacion->de_residuos) 
                {
                    foreach($acopiosPorCategorias as $acopioPorCategoria) {
                        if(rand(0, 1)) {

                            $residuo = $acopioPorCategoria->residuo;
                            $cantidad = $faker->randomFloat(2, 0, 0999.99);

                            $acopioPorCategoria->total += $cantidad;

                            $acopioPorCategoria->save();

                            $donacion->residuos()
                                ->attach($residuo, compact('cantidad'));
                        }
                    }
                }
            }
        }

        $dataset = new Collection(Config::get('reactivos'));
        $count = 0;
        $reactivos = $dataset->map(function ($reactivo) use (&$count) {
            if ($count < 2) {
                $reactivo['visible'] = false;
            }
            $count++;
            return Reactivo::factory()->create($reactivo);
        });
        
        $solicitantes = User::factory()->count(1)->create();

        foreach($solicitantes as $solicitante) {
            foreach($reactivos as $reactivo) {
                $solicitud = SolicitudReactivo::factory()->make();
                if($solicitud->estado) 
                    $reactivo->total -= $solicitud->cantidad;

                if($reactivo->visible) {
                    $solicitante->reactivosSolicitados()
                    ->attach($reactivo, $solicitud->toArray()); 
                }
                else {
                    $solicitud['estado'] = false;
                    $solicitud['otro_reactivo'] = $reactivo->nombre;
                    $solicitante->solicitudesOtroReactivo()
                        ->save($solicitud);
                }
            }   
        }

        $capturistas = User::factory()->count(1)->create();
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


                    // foreach ($residuos as $residuo) {
                    //     if(rand(0, 1)) {
                    //         $cantidad = $faker->randomFloat(2, 0, 9999.99);

                    //         if($acopi)

                    //         $donacion->residuos()
                    //             ->attach($residuo, compact('cantidad'));
                    //     }
                    // }