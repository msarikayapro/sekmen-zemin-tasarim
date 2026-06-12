<?php

namespace App\Http\Middleware;

use App\Models\Yonlendirme;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Yonlendir
{
    /**
     * yonlendirmeler tablosundan 301 yönlendirmeleri uygular (SEO geçişi).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $yol = trim($request->path(), '/'); // "/" => ""
        $harita = Yonlendirme::harita();

        if (isset($harita[$yol])) {
            $hedef = $harita[$yol];

            return redirect($hedef['yeni'], $hedef['tip'] ?: 301);
        }

        return $next($request);
    }
}
