<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\CMUser;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     * 
     */
    public function boot(): void
    {

        DatabaseNotifications::pollingInterval('10s');
        // DatabaseNotifications::trigger('livewire.notifications-trigger');

        // DatabaseNotifications::trigger('components.notification-trigger');
          
        FilamentColor::register([
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'sky' => Color::Sky
        ]);
        // Check if the locale is set in the session

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return auth()->user()->CMUser?->hasRole(Role::SuperAdmin) ? true : null;
        });

        Blade::if('canCM', function ($permission) {
            $cmUser = auth()->user()->CMUser ?? null;
            return $cmUser && ($cmUser->can($permission) || $cmUser->hasRole(Role::SuperAdmin));
        });

        Blade::if('roleCM', function ($role) {
            $cmUser = auth()->user()->CMUser ?? null;
            return $cmUser && ($cmUser->hasRole($role) || $cmUser->hasRole(Role::SuperAdmin));
        });


        // Custom directive for checking multiple permissions
        Blade::if('cananyCM', function (...$permissions) {
            $cmUser = auth()->user()->CMUser ?? null;
            return $cmUser && ($cmUser->hasAnyPermission($permissions) || $cmUser->hasRole(Role::SuperAdmin));
        });

        // Custom directive for checking if a permission is not granted
        Blade::if('cannotCM', function ($permission) {
            $cmUser = auth()->user()->CMUser ?? null;
            return !$cmUser || !$cmUser->can($permission);
        });
    }

    // Blade::if('canCM', function ($permission) {
    //     $cmUser = auth()->user()->CMUser ?? null;
    //     return $cmUser && ($cmUser->can($permission) || $cmUser->hasRole(Role::SuperAdmin));
    // });

    // // Custom directive for checking multiple permissions
    // Blade::if('cananyCM', function (...$permissions) {
    //     $cmUser = auth()->user()->CMUser ?? null;
    //     return $cmUser && ($cmUser->hasAnyPermission($permissions) || $cmUser->hasRole(Role::SuperAdmin));
    // });
}
