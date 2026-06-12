<?php

use App\Http\Middleware\PanelAdmin;
use App\Http\Middleware\PanelAuth;
use App\Http\Middleware\Yonlendir;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 301 yönlendirmeler — global (eşleşmeyen eski URL'ler de yakalanmalı, SEO geçişi)
        $middleware->prepend(Yonlendir::class);

        $middleware->alias([
            'panel.auth'  => PanelAuth::class,
            'panel.admin' => PanelAdmin::class,
        ]);

        // Paylaşımlı hosting / proxy arkasında doğru HTTPS şeması (Deploy Anayasası §4)
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
