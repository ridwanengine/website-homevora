<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            // cek role
            if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . Auth::user()->name);
            }

            if (session()->has('buy_now')) {
                return redirect()->route('checkout');
            }

            // return redirect()->route('Home')
            //     ->with('success', 'Selamat datang, ' . Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
