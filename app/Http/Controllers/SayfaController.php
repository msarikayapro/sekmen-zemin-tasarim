<?php

namespace App\Http\Controllers;

use App\Models\Sayfa;
use App\Support\SssService;

class SayfaController extends Controller
{
    public function hakkimizda()
    {
        $sayfa = Sayfa::anahtar('about');
        $ssler = SssService::sayfaSsleri('hakkimizda');

        return view('site.hakkimizda', [
            'sayfa'     => $sayfa,
            'ssler'     => $ssler,
            'faqSchema' => SssService::faqSchema($ssler),
        ]);
    }

    public function kvkk()
    {
        return view('site.statik', [
            'sayfa' => Sayfa::anahtar('kvkk'),
            'ssler' => SssService::sayfaSsleri('kvkk'),
        ]);
    }

    public function cerez()
    {
        return view('site.statik', [
            'sayfa' => Sayfa::anahtar('cerez'),
            'ssler' => SssService::sayfaSsleri('cerez'),
        ]);
    }
}
