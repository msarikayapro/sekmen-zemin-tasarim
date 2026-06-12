<?php

namespace App\Http\Controllers;

use App\Models\Hizmet;
use App\Models\Proje;
use App\Models\SeoLanding;
use App\Models\Urun;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        $statik = [
            ['loc' => route('home'), 'priority' => '1.0', 'freq' => 'weekly'],
            ['loc' => route('hakkimizda'), 'priority' => '0.6', 'freq' => 'monthly'],
            ['loc' => route('urunler.index'), 'priority' => '0.9', 'freq' => 'weekly'],
            ['loc' => route('hizmetler.index'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['loc' => route('projeler.index'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['loc' => route('iletisim'), 'priority' => '0.7', 'freq' => 'monthly'],
            ['loc' => route('kvkk'), 'priority' => '0.2', 'freq' => 'yearly'],
            ['loc' => route('cerez'), 'priority' => '0.2', 'freq' => 'yearly'],
        ];
        $urls = array_merge($urls, $statik);

        foreach (Urun::yayinda()->get() as $u) {
            $urls[] = ['loc' => route('urunler.show', $u), 'priority' => '0.7', 'freq' => 'monthly', 'lastmod' => $u->updated_at?->toAtomString()];
        }
        foreach (Proje::yayinda()->get() as $p) {
            $urls[] = ['loc' => route('projeler.show', $p), 'priority' => '0.6', 'freq' => 'monthly', 'lastmod' => $p->updated_at?->toAtomString()];
        }
        foreach (SeoLanding::yayinda()->get() as $s) {
            $urls[] = ['loc' => route('seo.landing', $s), 'priority' => '0.7', 'freq' => 'monthly'];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
