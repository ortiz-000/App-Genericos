<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 🔐 SESIÓN PERSISTENTE (COMO FACEBOOK)
        if (Auth::attempt($credentials, $request->filled('remember'))) {

             if (auth()->user()->hasRole('mensajero')) {
             return redirect()->route('mensajeria');
    }
    return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    // 🚪 LOGOUT MANUAL
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
