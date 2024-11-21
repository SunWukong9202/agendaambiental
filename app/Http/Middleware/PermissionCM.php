<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // Check if the last parameter is a string (it could be a pipe-separated list of permissions)
        $permissions = collect($permissions)->flatMap(function ($item) {
            return explode('|', $item);
        });

        $cmUser = $request->user()->CMUser ?? null;

        if($cmUser && $cmUser->hasRole(Role::SuperAdmin)) {
            return $next($request);
        }

        if (!$cmUser || !$cmUser->hasAnyPermission($permissions)) {
            abort(403); // Forbidden
        }

        return $next($request);
    }
}
