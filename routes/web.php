<?php

use Illuminate\Support\Facades\Route;
use Faker\Factory as Faker;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$materiales = [
    "Acero",
    "Aluminio",
    "Cobre",
    "Vidrio",
    "Plástico",
    "Madera",
    "Papel",
    "Hierro",
    "Bronce",
    "Latón",
    "Fibra de carbono",
    "Cerámica",
    "Tela",
    "Nylon",
    "Goma",
    "Piedra",
    "Teflón",
    "Polietileno",
    "Polipropileno",
];

Route::get('/', function (){
    [$users, $roles] = fakeUsers();
    return view('welcome', compact('users'), compact('roles'));
});

function fakeUsers() {
    $faker = Faker::create();
    $users = [];
    $roles = ['Admin', 'Becaro', 'Cliente'];
    for($i = 0; $i < 20; $i++) {
        $user = [
            'name' => $faker->name(),
            'email' => $faker->email(),
            'rol' => $roles[rand(0, count($roles) - 1)]
        ];
        $users[] = $user;
    }
    return [$users, $roles];
}

function fakeRequests($materiales) {
    $requests = [];
    $faker = Faker::create();
    $status = ['Aceptada', 'En curso', 'Rechazada'];
    
    for ($i = 0; $i < 10; $i++) {
        $state = $status[rand(0, count($status) - 1)];
        $req = [];
        $req['material'] = $materiales[rand(0, count($materiales) - 1)];
        $req['cantidad'] = round(rand(30, 100 * 5) / 100, 2);
        $begin = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d');
        $req['estado'] = $state;
        $req['solicitado'] = $begin;
        $req['aprobado'] = $state === 'En curso' ? 'En espera' : date_modify(new DateTime($begin), rand(1, 14) . ' days')->format('Y-m-d');
        
        $requests[] = $req;
    }
    
    return $requests;
}


 
Route::get('/perms', function () : Mixed {
   [$users, $roles] = fakeUsers();
    //compact('users') => 'users' => $users
    return view('permissions', compact('users'), compact('roles'));
})->name('permissions');

Route::get('/solicitudes', function () use ($materiales) {
    $requests = fakeRequests($materiales);
    return view('requestMaterials', compact('requests', 'materiales'));
});

Route::view('/registro_evento', 'eventRegistration');