<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerLoginController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        $rolecustomer = Role::where('name', 'customer')->first();
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $rolecustomer->id,
        ]);

        return redirect()->route('login')->with('success', 'Register Berhasil,Silahkan Login');
    }

    public function loginForm()
    {
        return view('auth.login');
    }
    // Peroses login//
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->role->name === 'admin') {
                // ini bagian pencegahaan supaya admin gak masuk ke customer
                Auth::logout();
                return back()->withErrors(['email' => 'Gunakan login admin']);
            }
            return redirect('/');
        }
        return back()->withErrors(['email' => 'Password atau Email salah']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
