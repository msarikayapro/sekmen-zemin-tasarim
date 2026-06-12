<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\PazarlamaAyari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PazarlamaController extends Controller
{
    public function index()
    {
        $pz = PazarlamaAyari::first() ?: new PazarlamaAyari([
            'event_mapping' => PazarlamaAyari::varsayilanEventMapping(),
        ]);

        return view('panel.pazarlama.index', [
            'pz' => $pz,
            'eventler' => $pz->aktifEventHaritasi(),
            'varsayilan' => PazarlamaAyari::varsayilanEventMapping(),
        ]);
    }

    public function update(Request $request)
    {
        $veri = $request->validate([
            'meta_pixel_id' => ['nullable', 'string', 'max:60'],
            'capi_test_code' => ['nullable', 'string', 'max:60'],
            'ga4_id' => ['nullable', 'string', 'max:40'],
            'gtm_id' => ['nullable', 'string', 'max:40'],
            'google_ads_id' => ['nullable', 'string', 'max:40'],
            'google_ads_label' => ['nullable', 'string', 'max:60'],
            'search_console_meta' => ['nullable', 'string', 'max:255'],
            'head_kod' => ['nullable', 'string'],
            'body_kod' => ['nullable', 'string'],
        ]);

        $veri['meta_pixel_aktif'] = $request->boolean('meta_pixel_aktif');
        $veri['capi_aktif'] = $request->boolean('capi_aktif');

        // CAPI token: boş bırakılırsa mevcut korunur (Anayasa §M9)
        $pz = PazarlamaAyari::first() ?: new PazarlamaAyari();
        if ($request->filled('capi_token')) {
            $veri['capi_token'] = $request->input('capi_token');
        }

        // Event mapping toggle'ları
        $harita = PazarlamaAyari::varsayilanEventMapping();
        foreach ($harita as $key => $cfg) {
            $harita[$key]['active'] = $request->boolean("event_$key");
        }
        $veri['event_mapping'] = $harita;

        $pz->fill($veri)->save();
        PazarlamaAyari::temizle();

        return back()->with('basari', 'Pazarlama & takip ayarları kaydedildi.');
    }

    /** Meta CAPI Test Event gönder. */
    public function testEvent()
    {
        $pz = PazarlamaAyari::first();
        if (! $pz || ! $pz->meta_pixel_id || ! $pz->capi_token) {
            return back()->withErrors(['capi' => 'Pixel ID ve CAPI Access Token gereklidir.']);
        }

        try {
            $url = "https://graph.facebook.com/v19.0/{$pz->meta_pixel_id}/events";
            $yanit = Http::asJson()->post($url, [
                'data' => [[
                    'event_name' => 'Lead',
                    'event_time' => time(),
                    'action_source' => 'website',
                    'event_source_url' => config('app.url'),
                    'user_data' => ['client_user_agent' => 'SekmenPanelTest'],
                ]],
                'test_event_code' => $pz->capi_test_code,
                'access_token' => $pz->capi_token,
            ]);

            if ($yanit->successful()) {
                return back()->with('basari', 'Test event başarıyla gönderildi. Meta Events Manager > Test Events ekranını kontrol edin.');
            }

            return back()->withErrors(['capi' => 'Meta yanıtı: ' . $yanit->body()]);
        } catch (\Throwable $e) {
            return back()->withErrors(['capi' => 'Hata: ' . $e->getMessage()]);
        }
    }
}
