<?php

use App\Enums\Permission;
use App\Enums\Role;
use App\Livewire\Client\Home;
use App\Livewire\Client\ListRepairs as ClientListRepairs;
use App\Livewire\Client\Repairment;
use App\Livewire\Panel\Dashboard;
use App\Livewire\Panel\Events\ListEvents;
use App\Livewire\Panel\Events\ListWastes;
use App\Livewire\Panel\ListUsers;
use App\Livewire\Panel\Login;
use App\Livewire\Panel\Users\ListSuppliers;
use App\Livewire\Panel\Users\RolesAndPermissions;
use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Client\Perfil;
use App\Livewire\Panel\Events\ListActives;
use App\Livewire\Panel\Events\ListDeliveries;
use App\Livewire\Panel\Events\ListItems;
use App\Livewire\Panel\Events\ListRepairs;
use App\Livewire\Panel\Events\RepairLog;
use App\Livewire\Panel\ListReagents;
use App\Livewire\RepairLogList;
use App\Mail\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/login', Login::class)->name('login');

Route::get('/mailable', function () {
    $user = User::find(2);

    return new Test($user);
});

Route::middleware('auth')->group(function () {
    // Route::group(['as' => 'client.', 'prefix' => 'client'], function () {
        Route::get('/home/{action?}', Home::class)
            ->name('home');

        Route::get('/profile', Perfil::class)
            ->name('donations');

        Route::get('/listRepairs', ClientListRepairs::class)
            ->middleware(['rolCM:' . Role::RepairTechnician->value])
            ->name('listRepairs');

        Route::get('/repairment/{record}', Repairment::class)
            ->middleware(['rolCM:' . Role::RepairTechnician->value])
            ->name('repairment');
        
        Route::get('/logout', function (Request $request) {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login');
        })->name('logout');
    // });
});


Route::middleware(['auth',
    'permissionCM:' . Permission::HasAdminPanelAccess->value
    ])->group(function () {
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/', Dashboard::class)
                ->name('dashboard');
    
            Route::get('/users', ListUsers::class)
                ->middleware(['permissionCM:' . Permission::ViewUsers->value])
                ->name('users');
    
            Route::get('/suppliers', ListSuppliers::class)
                ->middleware(['permissionCM:' . Permission::ViewSuppliers->value])
                ->name('suppliers');

            Route::get('suppliers/{supplier}/deliveries', ListDeliveries::class)
                ->middleware(['permissionCM:' . Permission::ViewDeliveries->value])
                ->name('supplier.deliveries');
    
            Route::get('/users/roles-and-permissions', RolesAndPermissions::class)
                ->middleware(['permissionCM:' . Permission::ViewRoles->value . '|' . Permission::ViewPermissions->value])
                ->name('roles-and-permissions');

            Route::get('/roles/{action}/{role?}', RolesAndPermissions::class)
                ->middleware(['permissionCM:' . Permission::ViewRoles->value . '|' . Permission::ViewPermissions->value])
                ->name('role.save');

            Route::get('/events/history', ListEvents::class)
                ->middleware(['permissionCM:' . Permission::ViewEvents->value])
                ->name('events.history');

            Route::get('/events/actived/{action?}/{event?}', ListActives::class)
                ->middleware(['permissionCM:' . Permission::AccessActiveEvents->value])
                ->name('events.actived');

            Route::get('/event/deliveries', ListDeliveries::class)
                ->middleware(['permissionCM:' . Permission::ViewDeliveries->value])
                ->name('events.deliveries');

            Route::get('/event/inventory/{tab?}/{status?}', ListItems::class)
                ->middleware(['permissionCM:' . Permission::ViewEventInventory->value])
                ->name('events.inventory');

            Route::get('/events/repairments', ListRepairs::class)
                ->middleware(['permissionCM:' . Permission::ViewRepairments->value])
                ->name('events.repairments');

            Route::get('/repairment/{movement}', RepairLogList::class)
                ->middleware(['permissionCM:' . Permission::ViewRepairments->value])
                ->name('events.repairmentLog');
    
            Route::get('/events/wastes', ListWastes::class)
                ->middleware(['permissionCM:' . Permission::ViewWastes->value])
                ->name('events.wastes');

            Route::get('/reagents', ListReagents::class)
                ->name('reagents');
    });     
});

