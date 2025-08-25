<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermissionCM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$rolesAndPermissions)
    {
        $cmUser = $request->user()->CMUser ?? null;

        if (!$cmUser || !$cmUser->hasAnyRole($rolesAndPermissions) && !$cmUser->hasAnyPermission($rolesAndPermissions)) {
            abort(403); // Forbidden
        }

        return $next($request);
    }
}
