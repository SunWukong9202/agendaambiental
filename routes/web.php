<?php

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
$roles = ['Admin', 'Becario', 'Cliente'];


Route::view('login', 'login')->name('login');

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


Route::middleware(['auth'])->group(function () use($materiales, $roles) {
    Route::get('logout', function (Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('login');

    })->name('logout');

    Route::get('/', function () {
        $user = Auth::user();
        return view('welcome');
    })->name('welcome');
    
    Route::get('/home', function () {
        $user = Auth::user();
        return view('home', compact('user'));
    })->name('home');

    Route::get('/informativeSection', function () {
        return view('informativeSection');
    })->name('informativeSection');
    
    Route::get('/recursos', function () {
        return view('recursos');
    })->name('recursos');
    
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
        
    Route::get('/perms', function () use($roles) {
       $users = User::all();
        return view('permissions', compact('users'), compact('roles'));
    })->name('permissions');
    
    Route::view('/events','events')->name('events');
    
    Route::get('/consumoResponsable', function () {
        return view('consumoResponsable');
    })->name('consumoResponsable');
    

    Route::get('/solicitudes', function () use ($materiales) {
        $requests = fakeRequests($materiales);
        return view('requestMaterials', compact('requests', 'materiales'));
    })->name('solicitudes');
    
    Route::view('/registro_evento', 'eventRegistration')->name('registro_evento');
    Route::view('/acompañamiento', 'acompañamiento')->name('accompany');
    Route::view('/acopio', 'acopio')->name('acopio');
    Route::view('/registroDonante', 'registroDonante')->name('registroDonante');
});
