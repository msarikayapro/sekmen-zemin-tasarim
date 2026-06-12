<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use App\Support\SssService;
use Illuminate\Http\Request;

class IletisimController extends Controller
{
    public function index(Request $request)
    {
        $urunler = Urun::yayinda()->orderBy('ad')->get(['id', 'ad']);
        $ssler = SssService::sayfaSsleri('iletisim');

        return view('site.iletisim', [
            'urunler'     => $urunler,
            'seciliUrun'  => $request->query('urun'),
            'ssler'       => $ssler,
            'faqSchema'   => SssService::faqSchema($ssler),
        ]);
    }
}
