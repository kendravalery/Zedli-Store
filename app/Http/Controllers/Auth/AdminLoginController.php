<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.loginAdmin');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // hanya admin boleh masuxk
            if (Auth::user()->role->name !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Bukan admin']);
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email / password salah']);
    }
}
