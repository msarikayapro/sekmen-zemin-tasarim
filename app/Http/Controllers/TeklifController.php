<?php

namespace App\Http\Controllers;

use App\Mail\YeniTalepMail;
use App\Models\Talep;
use App\Models\Urun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TeklifController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bot doldurursa sessizce başarı dön (spam'i ele verme)
        if ($request->filled('website')) {
            return back()->with('basari', 'Talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.');
        }

        $veri = $request->validate([
            'ad'         => ['required', 'string', 'max:120'],
            'telefon'    => ['required', 'string', 'max:30'],
            'email'      => ['nullable', 'email', 'max:150'],
            'il_ilce'    => ['nullable', 'string', 'max:120'],
            'ilgi_alani' => ['nullable', 'string', 'max:150'],
            'urun_id'    => ['nullable', 'integer', 'exists:urunler,id'],
            'm2'         => ['nullable', 'string', 'max:50'],
            'mesaj'      => ['nullable', 'string', 'max:3000'],
            'kvkk_onay'  => ['accepted'],
            'kaynak'     => ['nullable', 'string', 'max:60'],
        ], [], [
            'ad' => 'Ad Soyad',
            'telefon' => 'Telefon',
            'kvkk_onay' => 'KVKK onayı',
        ]);

        // Ürün adından otomatik ilgi alanı
        if (! empty($veri['urun_id']) && empty($veri['ilgi_alani'])) {
            $veri['ilgi_alani'] = optional(Urun::find($veri['urun_id']))->ad;
        }

        $veri['kvkk_onay'] = true;
        $veri['durum'] = 'yeni';

        $talep = Talep::create($veri);

        // E-posta bildirimi (dış servis → try-catch, Deploy Anayasası §8)
        try {
            $alici = config('mail.lead_notify', config('mail.from.address'));
            Mail::to($alici)->send(new YeniTalepMail($talep));
        } catch (\Throwable $e) {
            Log::warning('Teklif bildirim e-postası gönderilemedi: ' . $e->getMessage());
        }

        return back()
            ->with('basari', 'Talebiniz başarıyla alındı! Ekibimiz en kısa sürede sizinle iletişime geçecek.')
            ->withFragment('teklif');
    }
}
