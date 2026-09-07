<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Allow the request only when the authenticated user has one of the given roles.
     * Usage: ->middleware('role:professional') or 'role:homeowner,admin'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = auth()->user();

        if (! in_array($user->role, $roles, true)) {
            return redirect()->route('dashboard')->with('error', 'This action is available only for ' . implode(' / ', $roles) . ' accounts.');
        }

        return $next($request);
    }
}