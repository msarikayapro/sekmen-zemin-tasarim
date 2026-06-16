<?php

use App\Http\Controllers\HizmetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IletisimController;
use App\Http\Controllers\ProjeController;
use App\Http\Controllers\SayfaController;
use App\Http\Controllers\SeoLandingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TeklifController;
use App\Http\Controllers\UrunController;
use App\Http\Controllers\Panel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend (genel site)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hakkimizda', [SayfaController::class, 'hakkimizda'])->name('hakkimizda');

Route::get('/urunler', [UrunController::class, 'index'])->name('urunler.index');
Route::get('/urunler/{urun}', [UrunController::class, 'show'])->name('urunler.show');

Route::get('/hizmetler', [HizmetController::class, 'index'])->name('hizmetler.index');

Route::get('/projeler', [ProjeController::class, 'index'])->name('projeler.index');
Route::get('/projeler/{proje}', [ProjeController::class, 'show'])->name('projeler.show');

Route::get('/iletisim', [IletisimController::class, 'index'])->name('iletisim');
Route::post('/teklif', [TeklifController::class, 'store'])->name('teklif.store');

Route::get('/kvkk', [SayfaController::class, 'kvkk'])->name('kvkk');
Route::get('/cerez-politikasi', [SayfaController::class, 'cerez'])->name('cerez');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Yönetim Paneli (/panel)
|--------------------------------------------------------------------------
*/
Route::prefix('panel')->name('panel.')->group(function () {
    // Giriş (misafir)
    Route::get('/giris', [Panel\AuthController::class, 'showLogin'])->name('login');
    Route::post('/giris', [Panel\AuthController::class, 'login'])->name('login.post');
    Route::post('/cikis', [Panel\AuthController::class, 'logout'])->name('logout');

    // Giriş yapmış (Admin + Editör)
    Route::middleware('panel.auth')->group(function () {
        Route::get('/', [Panel\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/raporlar', [Panel\DashboardController::class, 'raporlar'])->name('raporlar');

        // Ürünler
        Route::post('/urunler/sirala', [Panel\UrunController::class, 'sirala'])->name('urunler.sirala');
        Route::delete('/urun-gorsel/{gorsel}', [Panel\UrunController::class, 'gorselSilFn'])->name('urunler.gorsel.sil');
        Route::resource('urunler', Panel\UrunController::class)->except('show')->parameters(['urunler' => 'urun']);

        // Kategoriler
        Route::resource('kategoriler', Panel\KategoriController::class)->except('show')->parameters(['kategoriler' => 'kategori']);

        // Projeler
        Route::delete('/proje-gorsel/{gorsel}', [Panel\ProjeController::class, 'gorselSilFn'])->name('projeler.gorsel.sil');
        Route::resource('projeler', Panel\ProjeController::class)->except('show')->parameters(['projeler' => 'proje']);

        // Öncesi/Sonrası
        Route::resource('oncesi-sonrasi', Panel\OncesiSonrasiController::class)->except('show')->parameters(['oncesi-sonrasi' => 'oncesiSonrasi']);

        // Hizmetler
        Route::resource('hizmetler', Panel\HizmetController::class)->except('show')->parameters(['hizmetler' => 'hizmet']);

        // Yorumlar
        Route::resource('yorumlar', Panel\YorumController::class)->except('show')->parameters(['yorumlar' => 'yorum']);

        // SSS
        Route::resource('sss', Panel\SssController::class)->except('show');

        // Banner
        Route::resource('bannerlar', Panel\BannerController::class)->except('show')->parameters(['bannerlar' => 'banner']);

        // Vitrin (Showcase)
        Route::post('/showcases/sirala', [Panel\ShowcaseController::class, 'sirala'])->name('showcases.sirala');
        Route::resource('showcases', Panel\ShowcaseController::class)->except('show')->parameters(['showcases' => 'showcase']);

        // Blog (faz 2)
        Route::resource('blog', Panel\BlogController::class)->except('show');

        // İçerik / statik sayfalar
        Route::get('/sayfalar', [Panel\SayfaController::class, 'index'])->name('sayfalar.index');
        Route::get('/sayfalar/{sayfa}/duzenle', [Panel\SayfaController::class, 'edit'])->name('sayfalar.edit');
        Route::put('/sayfalar/{sayfa}', [Panel\SayfaController::class, 'update'])->name('sayfalar.update');

        // Teklif talepleri (lead)
        Route::get('/talepler/export', [Panel\TalepController::class, 'export'])->name('talepler.export');
        Route::get('/talepler', [Panel\TalepController::class, 'index'])->name('talepler.index');
        Route::get('/talepler/{talep}', [Panel\TalepController::class, 'show'])->name('talepler.show');
        Route::put('/talepler/{talep}/durum', [Panel\TalepController::class, 'updateDurum'])->name('talepler.durum');
        Route::delete('/talepler/{talep}', [Panel\TalepController::class, 'destroy'])->name('talepler.destroy');

        // SEO landing
        Route::resource('seo-landing', Panel\SeoLandingController::class)->except('show')->parameters(['seo-landing' => 'seoLanding']);

        // 301 yönlendirmeler
        Route::get('/yonlendirmeler', [Panel\YonlendirmeController::class, 'index'])->name('yonlendirmeler.index');
        Route::post('/yonlendirmeler', [Panel\YonlendirmeController::class, 'store'])->name('yonlendirmeler.store');
        Route::put('/yonlendirmeler/{yonlendirme}/toggle', [Panel\YonlendirmeController::class, 'toggle'])->name('yonlendirmeler.toggle');
        Route::delete('/yonlendirmeler/{yonlendirme}', [Panel\YonlendirmeController::class, 'destroy'])->name('yonlendirmeler.destroy');

        /*
        | Yalnızca Admin: ayarlar, pazarlama, kullanıcılar, sistem
        */
        Route::middleware('panel.admin')->group(function () {
            Route::get('/ayarlar', [Panel\AyarController::class, 'index'])->name('ayarlar.index');
            Route::post('/ayarlar', [Panel\AyarController::class, 'update'])->name('ayarlar.update');

            Route::get('/pazarlama', [Panel\PazarlamaController::class, 'index'])->name('pazarlama.index');
            Route::post('/pazarlama', [Panel\PazarlamaController::class, 'update'])->name('pazarlama.update');
            Route::post('/pazarlama/test-event', [Panel\PazarlamaController::class, 'testEvent'])->name('pazarlama.test');

            Route::resource('kullanicilar', Panel\KullaniciController::class)->except('show')->parameters(['kullanicilar' => 'kullanici']);

            // Sistem / bakım (secret route — Deploy Anayasası §5)
            $secret = env('SYSTEM_SECRET', 'sekmen-sistem');
            Route::prefix('sistem-' . $secret)->name('sistem.')->group(function () {
                Route::get('/', [Panel\SystemController::class, 'panel'])->name('panel');
                Route::post('/migrate', [Panel\SystemController::class, 'runUpdate'])->name('migrate');
                Route::post('/cache', [Panel\SystemController::class, 'clearCache'])->name('cache');
            });
        });
    });
});

/*
|--------------------------------------------------------------------------
| SEO Landing (şehir+ürün) — tek segmentli catch-all (EN SONDA)
|--------------------------------------------------------------------------
*/
Route::get('/{seoLanding:slug}', [SeoLandingController::class, 'show'])
    ->where('seoLanding', '^(?!panel|urunler|projeler|hizmetler|api|storage|build|sitemap).+$')
    ->name('seo.landing');
