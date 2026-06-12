<?php

namespace App\Http\Controllers;

use App\Models\SeoLanding;
use App\Models\Urun;

class SeoLandingController extends Controller
{
    public function show(SeoLanding $seoLanding)
    {
        abort_if($seoLanding->durum !== 'yayin', 404);

        $urunler = Urun::yayinda()->with('gorseller')->sirali()->take(6)->get();

        return view('site.seo-landing', [
            'sayfa'   => $seoLanding,
            'urunler' => $urunler,
            'waMesaj' => 'Merhaba, ' . $seoLanding->baslik_h1 . ' hakkında teklif almak istiyorum.',
        ]);
    }
}
