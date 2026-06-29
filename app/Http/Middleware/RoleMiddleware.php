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
                'pembeli' => redirect()->route('home'),
                'penjual' => redirect()->route('dashboard_penjual.penjual'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
