<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\OncesiSonrasi;
use App\Models\Proje;
use App\Models\Talep;
use App\Models\Urun;
use App\Models\Yorum;

class DashboardController extends Controller
{
    public function index()
    {
        return view('panel.dashboard', [
            'bekleyenTeklif' => Talep::where('durum', 'yeni')->count(),
            'toplamTalep'    => Talep::count(),
            'urunSayisi'     => Urun::count(),
            'projeSayisi'    => Proje::count(),
            'yorumSayisi'    => Yorum::count(),
            'oncesiSonrasi'  => OncesiSonrasi::count(),
            'sonTalepler'    => Talep::latest()->take(5)->get(),
        ]);
    }

    public function raporlar()
    {
        $durumlar = Talep::selectRaw('durum, count(*) as adet')->groupBy('durum')->pluck('adet', 'durum');

        return view('panel.raporlar', [
            'durumlar'    => $durumlar,
            'toplamTalep' => Talep::count(),
            'urunSayisi'  => Urun::count(),
            'projeSayisi' => Proje::count(),
            'aylikTalep'  => Talep::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ]);
    }
}
