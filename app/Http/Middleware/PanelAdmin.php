<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PanelAdmin
{
    /**
     * Yalnızca Admin rolüne izin verir (kullanıcı yönetimi, ayarlar, pazarlama, sistem).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403, 'Bu işlem için yönetici yetkisi gereklidir.');
        }

        return $next($request);
    }
}
