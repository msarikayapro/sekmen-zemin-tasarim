<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('panel.dashboard');
        }

        return view('panel.auth.login');
    }

    public function login(Request $request)
    {
        $kimlik = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $hatirla = $request->boolean('remember');

        if (! Auth::attempt($kimlik, $hatirla)) {
            throw ValidationException::withMessages([
                'email' => 'E-posta veya şifre hatalı.',
            ]);
        }

        if (! Auth::user()->aktif) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Hesabınız pasif durumda.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('panel.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('panel.login');
    }
}
