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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/perms', function (): Mixed {
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
    //compact('users') => 'users' => $users
    return view('permissions', compact('users'), compact('roles'));
})->name('permissions');

Route::view('/registro_evento', 'eventRegistration');