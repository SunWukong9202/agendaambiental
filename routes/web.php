<?php

use App\Livewire\AdminPanel;
use App\Livewire\Pages\Acopios\Acopio;
use App\Livewire\Pages\Acopios\Activo;
use App\Livewire\Pages\Acopios\Proveedores;
use App\Livewire\Pages\Client\Perfil;
use App\Livewire\Pages\Client\Solicitudes;
use App\Livewire\Pages\Donaciones\Reactivos as DonacionesReactivos;
use App\Livewire\Pages\Events;
use App\Livewire\Pages\Inventarios\Articulos;
use App\Livewire\Pages\Inventarios\Reactivos;
use App\Livewire\Pages\Solicitudes\Reactivos as SolicitudesReactivos;
use App\Livewire\Pages\Users;
use App\Models\InventarioAcopio\Articulo;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
//as = name -> asi que esto se pega al inicio de name

Route::view('login', 'client.login')->name('login');

Route::post('login', function (Request $req){
    $credentials = $req->validate([
        'clave' => ['required'],
        'password' => ['required'],
    ]);

    if(Auth::attempt([
        'clave' => $credentials['clave'],
        'password' => $credentials['password']]
        )) 
    {
        $req->session?->regenerate();

        return redirect()->intended();
    }

    return back()->withErrors([
        'clave' => 'Credenciales erroneas',
    ])->onlyInput('clave');
});

Route::get('logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('login');

})->name('logout');

Route::group(['middleware' => 'auth'], function () {
    
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        // Route::get('/', AdminPanel::class)->name('panel');
        Route::get('/', Users::class)->name('users');
        
        Route::get('/events', Events::class)->name('events');
        Route::get('/events/acopio/{action}/{id?}', Acopio::class)->name('acopio');
        Route::get('/acopios/activos/{acopio}', Activo::class)->name('acopios.activos');
    
        Route::get('/proveedores', Proveedores::class)->name('proveedores');
    
        Route::get('/inventario/reactivos', Reactivos::class)
            ->name('inventario.reactivos');
        Route::get('/solicitudes/reactivos', SolicitudesReactivos::class)
            ->name('solicitudes.reactivos');
        Route::get('/donaciones/reactivos', DonacionesReactivos::class)
            ->name('donaciones.reactivos');
    
        Route::get('/inventario/articulos', Articulos::class)
            ->name('inventario.articulos');
    });

    Route::get('/', function () {
        return view('layout');
    })->name('agendaAmbiental');

    Route::view('/modulo', 'client.home')->name('client.home');
    Route::view('/modulo/testing', 'client.home')->name('client.home');

    Route::get('/modulo/solicitudes/{type}', Solicitudes::class)->name('solicitudes');

    Route::get('/modulo/profile', Perfil::class)->name('user.profile');

});



Route::get('/hello', function () {
    return 'Hello world';
});