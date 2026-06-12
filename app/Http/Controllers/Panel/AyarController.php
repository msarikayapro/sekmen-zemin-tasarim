<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Concerns\GorselYukle;
use App\Models\Ayar;
use Illuminate\Http\Request;

class AyarController extends Controller
{
    use GorselYukle;

    public function index()
    {
        return view('panel.ayarlar.index', ['ayarlar' => Ayar::tumu()]);
    }

    public function update(Request $request)
    {
        $alanlar = [
            'site_basligi', 'slogan', 'kurulus_yili', 'uygulama_m2', 'proje_sayisi', 'mutlu_musteri',
            'telefon', 'telefon2', 'whatsapp', 'whatsapp_mesaj', 'email', 'adres', 'calisma_saatleri',
            'harita_embed', 'sosyal_instagram', 'sosyal_facebook', 'sosyal_youtube', 'tema_renk',
            'hizmet_bolgeleri', 'footer_aciklama',
        ];

        $veri = [];
        foreach ($alanlar as $alan) {
            $veri[$alan] = $request->input($alan, '');
        }

        // Görsel ayarları (logo / koyu logo / favicon / katalog)
        foreach (['logo', 'logo_koyu', 'favicon'] as $g) {
            if ($request->hasFile($g)) {
                $veri[$g] = $this->gorselKaydet($request->file($g), 'ayarlar', Ayar::get($g));
            }
        }
        if ($request->hasFile('katalog_pdf')) {
            $request->validate(['katalog_pdf' => ['file', 'mimes:pdf', 'max:20480']]);
            $veri['katalog_pdf'] = $request->file('katalog_pdf')->store('katalog', 'public');
        }

        Ayar::topluKaydet($veri);

        return back()->with('basari', 'Ayarlar kaydedildi.');
    }
}
