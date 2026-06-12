<?php

namespace Database\Seeders;

use App\Models\Yonlendirme;
use Illuminate\Database\Seeder;

class YonlendirmeSeeder extends Seeder
{
    public function run(): void
    {
        // sekmenyapi.com eski URL'lerinden örnek 301 haritası (SEO geçişi)
        $haritalar = [
            ['urunler.html', '/urunler'],
            ['hakkimizda.html', '/hakkimizda'],
            ['iletisim.html', '/iletisim'],
            ['referanslar.html', '/projeler'],
            ['galeri.html', '/projeler'],
        ];

        foreach ($haritalar as [$eski, $yeni]) {
            Yonlendirme::updateOrCreate(['eski_url' => $eski], [
                'yeni_url' => $yeni,
                'tip' => 301,
                'aktif' => true,
            ]);
        }

        Yonlendirme::temizle();
    }
}
