<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $cmUser = $request->user()->CMUser ?? null;

        if($cmUser && $cmUser->hasRole(Role::SuperAdmin->value)) {
            return $next($request);
        }

        if (!$cmUser || !$cmUser->hasAnyRole($roles)) {
            abort(403); // Forbidden
        }

        return $next($request);
    }
}
