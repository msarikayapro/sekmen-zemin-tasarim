<?php

namespace App\Http\Controllers;

use App\Models\Hizmet;
use App\Support\SssService;

class HizmetController extends Controller
{
    public function index()
    {
        $hizmetler = Hizmet::yayinda()->sirali()->get();
        $ssler = SssService::sayfaSsleri('hizmetler');

        return view('site.hizmetler', [
            'hizmetler' => $hizmetler,
            'ssler'     => $ssler,
            'faqSchema' => SssService::faqSchema($ssler),
        ]);
    }
}
