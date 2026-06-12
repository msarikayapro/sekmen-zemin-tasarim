<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\PazarlamaAyari;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Deploy Anayasası §4: production'da HTTPS şemasını zorla
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useTailwind();

        // Yetki: yalnızca Admin (kullanıcı, ayarlar, pazarlama, sistem)
        Gate::define('admin', fn ($user) => $user->isAdmin());

        // Frontend layout'a global verileri paylaş (footer kategorileri + tracking)
        View::composer('layouts.site', function ($view) {
            $view->with('footerKategoriler', Kategori::orderBy('sira')->get());
            $view->with('pazarlamaAyari', PazarlamaAyari::tekil());
        });
    }
}
