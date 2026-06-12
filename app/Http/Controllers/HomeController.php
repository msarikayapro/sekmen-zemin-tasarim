<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Hizmet;
use App\Models\OncesiSonrasi;
use App\Models\Proje;
use App\Models\Sayfa;
use App\Models\Urun;
use App\Models\Yorum;
use App\Support\SssService;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Banner::yayinda()->sirali()->first();

        $oneCikanUrunler = Urun::yayinda()->where('one_cikan', true)->with('gorseller')->sirali()->take(8)->get();
        if ($oneCikanUrunler->count() < 4) {
            $oneCikanUrunler = Urun::yayinda()->with('gorseller')->sirali()->take(8)->get();
        }

        $hizmetler = Hizmet::yayinda()->sirali()->take(4)->get();
        $projeler  = Proje::yayinda()->where('one_cikan', true)->with('gorseller')->sirali()->take(6)->get();
        if ($projeler->isEmpty()) {
            $projeler = Proje::yayinda()->with('gorseller')->sirali()->take(6)->get();
        }
        $yorumlar = Yorum::yayinda()->sirali()->take(4)->get();
        $oncesiSonrasi = OncesiSonrasi::yayinda()
            ->whereNot('oncesi_gorsel', '')->whereNot('sonrasi_gorsel', '')
            ->orderBy('sira')->first();

        $sayfa  = Sayfa::anahtar('home');
        $ssler  = SssService::sayfaSsleri('ana_sayfa');

        return view('site.home', [
            'banner'          => $banner,
            'oneCikanUrunler' => $oneCikanUrunler,
            'hizmetler'       => $hizmetler,
            'projeler'        => $projeler,
            'yorumlar'        => $yorumlar,
            'oncesiSonrasi'   => $oncesiSonrasi,
            'sayfa'           => $sayfa,
            'ssler'           => $ssler,
            'faqSchema'       => SssService::faqSchema($ssler),
        ]);
    }
}
