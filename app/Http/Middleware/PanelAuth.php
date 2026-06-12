<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PanelAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('panel.login');
        }

        if (! $user->aktif) {
            Auth::logout();

            return redirect()->route('panel.login')->withErrors([
                'email' => 'Hesabınız pasif durumda. Lütfen yöneticiyle iletişime geçin.',
            ]);
        }

        return $next($request);
    }
}
