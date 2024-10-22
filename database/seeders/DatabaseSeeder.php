<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\CRETIB;
use App\Models\Event;
use App\Models\Item;
use App\Models\Reagent;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(5)->create();

        Event::factory()->count(5)->create([
            'user_id' => fake()->randomElement($users)->id,
        ]);

        Supplier::factory()->count(5)->create();

        Reagent::factory()->count(5)->create();

        Item::factory()->count(5)->create();

        $catalogo = new Collection(Config::get('catalogos.residuos'));
        
        $residuos = $catalogo->map(function ($residuo) {
            return Waste::create([
                'category' => $residuo,
                'unit' => 'Kg'
            ]);
        });
    }
}

// $acopio = Evento::factory()->count(1)->create()->first();
// $acopiador = User::factory()->count(1)->create()->first();
// $donadores = User::factory()->count(5)->create();
// $proveedores = Proveedor::factory()->count(15)->create();
// $admin = User::factory()->create([
//     'clave' => '112233'
// ]);
// // $articulos = Articulo::factory()->count(30)->create();

// $residuos = $catalogo->map(function ($residuo) {
//     return Residuo::create([
//         'categoria' => $residuo,
//     ]);
// });

// $catalogo = new Collection(Config::get('opciones.articulos'));

// $articulos = $catalogo->map(function ($articulo) {
//     return Articulo::factory()->create([
//         'nombre' => $articulo,
//     ]);
// });

// $acopiosPorCategorias = $residuos->map(function ($residuo) use ($acopio) {
//     return AcopioPorCategoria::create([
//         'acopio_id' => $acopio->id,
//         'residuo_id' => $residuo->id
//     ]);
// });

// foreach ($donadores as $donador) {

//     $donaciones = Donacion::factory()->count(2)->create([
//         'capturista_id' => $acopiador->id,
//         'donador_id' => $donador->id,
//         'acopio_id' => $acopio->id
//     ]);

//     foreach ($donaciones as $donacion) {
//         if($donacion->de_residuos) 
//         {
//             foreach($acopiosPorCategorias as $acopioPorCategoria) {
//                 if(rand(0, 1)) {

//                     $residuo = $acopioPorCategoria->residuo;
//                     $cantidad = $faker->randomFloat(2, 0, 0999.99);

//                     $acopioPorCategoria->total += $cantidad;

//                     $acopioPorCategoria->save();

//                     $donacion->residuos()
//                         ->attach($residuo, compact('cantidad'));
//                 }
//             }
//         }
//     }
// }

// $dataset = new Collection(Config::get('reactivos'));
// $count = 0;
// $reactivos = $dataset->map(function ($reactivo) use (&$count) {
//     if ($count < 2) {
//         $reactivo['visible'] = false;
//     }
//     $count++;
//     return Reactivo::factory()->create($reactivo);
// });

// $solicitantes = User::factory()->count(1)->create();

// foreach($solicitantes as $solicitante) {
//     foreach($reactivos as $reactivo) {
//         $solicitud = SolicitudReactivo::factory()->make();
//         if($solicitud->estado) 
//             $reactivo->total -= $solicitud->cantidad;

//         if($reactivo->visible) {
//             $solicitante->reactivosSolicitados()
//             ->attach($reactivo, $solicitud->toArray()); 
//         }
//         else {
//             $solicitud['estado'] = false;
//             $solicitud['otro_reactivo'] = $reactivo->nombre;
//             $solicitante->solicitudesOtroReactivo()
//                 ->save($solicitud);
//         }
//     }   
// }

// $capturistas = User::factory()->count(1)->create();
// foreach ($capturistas as $capturista) {
//     foreach ($reactivos as $reactivo) {
//         $captura = DonacionReactivo::factory()->make();
//         $reactivo->total += $captura->cantidad;
         
//         $capturista->reactivosDonados()
//             ->attach($reactivo, $captura->toArray());
//     }
// }

// $reactivos->each(fn($reactivo) => $reactivo->save());

                    // foreach ($residuos as $residuo) {
                    //     if(rand(0, 1)) {
                    //         $cantidad = $faker->randomFloat(2, 0, 9999.99);

                    //         if($acopi)

                    //         $donacion->residuos()
                    //             ->attach($residuo, compact('cantidad'));
                    //     }
                    // }