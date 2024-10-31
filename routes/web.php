<?php

use App\Enums\Permission;
use App\Livewire\Client\Home;
use App\Livewire\Panel\Dashboard;
use App\Livewire\Panel\Events\ListEvents;
use App\Livewire\Panel\Events\ListWastes;
use App\Livewire\Panel\ListUsers;
use App\Livewire\Panel\Login;
use App\Livewire\Panel\Users\ListSuppliers;
use App\Livewire\Panel\Users\RolesAndPermissions;
use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Client\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    // Route::group(['as' => 'client.', 'prefix' => 'client'], function () {
        Route::get('/', Home::class)
            ->name('home');

        Route::get('/profile', Perfil::class)
            ->name('donations');
        
        Route::get('/logout', function (Request $request) {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login');
        })->name('logout');
    // });
});


Route::middleware(['auth',
    'permission:' . Permission::HasAdminPanelAccess->value
    ])->group(function () {
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/', Dashboard::class)
                ->name('dashboard');
    
            Route::get('/users', ListUsers::class)
                ->middleware(['permission:' . Permission::ViewUsers->value])
                ->name('users');
    
            Route::get('/users/suppliers', ListSuppliers::class)
                ->middleware(['permission:' . Permission::ViewSuppliers->value])
                ->name('users.suppliers');
    
            Route::get('/users/roles-and-permissions', RolesAndPermissions::class)
                ->middleware(['permission:' . Permission::ViewRoles->value . '|' . Permission::ViewPermissions->value])
                ->name('roles-and-permissions');

            Route::get('/roles/{action}/{role?}', RolesAndPermissions::class)
                ->middleware(['permission:' . Permission::ViewRoles->value . '|' . Permission::ViewPermissions->value])
                ->name('role.save');

            Route::get('/events/history', ListEvents::class)
                ->middleware(['permission:' . Permission::ViewEvents->value])
                ->name('events.history');
    
            Route::get('/events/wastes', ListWastes::class)
                ->middleware(['permission:' . Permission::ViewWastes->value])
                ->name('events.wastes');
    });     
});

