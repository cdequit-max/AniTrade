<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /** Usage: ->middleware('role:store') or 'role:buyer'. */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if ($user && $user->role !== $role) {
            // Wrong area for this account: send them to their own dashboard.
            return redirect()->route($user->dashboardRoute());
        }

        return $next($request);
    }
}
