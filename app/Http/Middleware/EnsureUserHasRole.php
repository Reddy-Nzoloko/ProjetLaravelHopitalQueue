<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware(\App\Http\Middleware\EnsureUserHasRole::class . ':receptionniste')
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        if (! $request->user()) {
            abort(403);
        }

        if ($role && ! $request->user()->hasRole($role)) {
            abort(403);
        }

        return $next($request);
    }
}
