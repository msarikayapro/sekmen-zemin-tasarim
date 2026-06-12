<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Deploy Anayasası §5 — SSH'sız web tabanlı bakım.
 * Rotalar tahmin edilemez bir secret ile + super-admin (panel.admin) ile korunur.
 */
class SystemController extends Controller
{
    public function panel()
    {
        return view('panel.sistem.index');
    }

    /** migrate --force */
    public function runUpdate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $cikti = Artisan::output();
            $this->cacheTemizle();

            return back()->with('basari', 'Migration çalıştırıldı:<br><pre class="text-xs mt-2 whitespace-pre-wrap">' . e($cikti) . '</pre>');
        } catch (\Throwable $e) {
            return back()->withErrors(['sistem' => 'Migration hatası: ' . $e->getMessage()]);
        }
    }

    /** optimize:clear + view:clear + önbellek dosyalarını sil */
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('view:clear');
            $this->cacheTemizle();

            return back()->with('basari', 'Tüm önbellekler temizlendi (config, route, view, cache).');
        } catch (\Throwable $e) {
            return back()->withErrors(['sistem' => 'Önbellek temizleme hatası: ' . $e->getMessage()]);
        }
    }

    /** bootstrap/cache içindeki derlenmiş dosyaları elle sil (Deploy Anayasası §5.3) */
    protected function cacheTemizle(): void
    {
        foreach (['config.php', 'routes-v7.php', 'services.php', 'packages.php'] as $dosya) {
            $yol = base_path('bootstrap/cache/' . $dosya);
            if (File::exists($yol)) {
                File::delete($yol);
            }
        }

        // Uygulama önbelleklerini de temizle
        \App\Models\Ayar::temizle();
        \App\Models\PazarlamaAyari::temizle();
        \App\Models\Yonlendirme::temizle();
    }
}
