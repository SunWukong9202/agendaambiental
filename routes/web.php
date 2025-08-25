<?php

use App\Enums\Permission;
use App\Enums\Role;
use App\Livewire\Client\History;
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
use App\Livewire\Panel\ReagentManagment;
use App\Livewire\RepairLogList;
use App\Mail\Test;
use App\Models\Pivots\Report;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPdf\Facades\Pdf;

// Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
// });

// Route::get('/mailable', function () {
//     $user = User::find(2);

//     return new Test($user);
// });

// Route::get('see-pdf', function () {
//     $pdf = SnappyPdf::setOptions([
//         'encoding' => 'utf-8',
//         'enable-local-file-access' => true
//     ])
//     ->loadView('pdf.report', [
//         'from' => User::factory()->make(),
//         'to' => Supplier::factory()->make(),
//         'report' => [
//             'created_at' => now()->format('d M, Y h:i A')
//         ],
//         'deliveries' => [

//         ],
//         'total' => '00.00',
//     ])
//     ->footerView('pdf.footer');

//     return $pdf->inline();
// });

// Route::get('spatie-pdf', function () {
//     return Pdf::view('pdf.deliveries')
//         ->name('deliveries.pdf');
// });

// Route::view('pdf', 'pdf.deliveries', [
//     'from' => User::factory()->make(),
//     'to' => Supplier::factory()->make(),
//     'report' => [
//         'created_at' => now()->format('d M, Y h:i A')
//     ],
//     'deliveries' => [

//     ],
//     'total' => '00.00'

// ]);

Route::middleware('auth')->group(function () {
    // Route::group(['as' => 'client.', 'prefix' => 'client'], function () {
        Route::get('/home/{action?}', Home::class)
            ->name('home');

        Route::get('/profile', History::class)
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

            return redirect('/');
        })->name('logout');
    // });
});


Route::middleware(['auth',
    'permissionCM:' . Permission::HasAdminPanelAccess->value
    ])->group(function () {
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/dashboard', Dashboard::class)
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

            Route::get('reports/{report}', function (Report $report) {

                $pdfPath = storage_path("app/public/".$report->file_path);

                return response()->file($pdfPath);

            })->name('reports');
    
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

            Route::get('/reagents/managment', ReagentManagment::class)
                ->name('reagents.managment');
    });     
});

