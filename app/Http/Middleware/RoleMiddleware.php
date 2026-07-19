<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role->name !== $role) {
            return match (Auth::user()->role->name) {
                'admin' => redirect()->route('admin.dashboard'),

                'customer' => redirect()->route('home'),

                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
