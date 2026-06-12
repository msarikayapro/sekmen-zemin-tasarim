<?php

namespace Database\Seeders;

use App\Models\SeoLanding;
use Illuminate\Database\Seeder;

class SeoLandingSeeder extends Seeder
{
    public function run(): void
    {
        $sayfalar = [
            ['Konya Kilit Taşı Uygulama', 'konya-kilit-tasi', 'Konya', 'Kilit Taşı'],
            ['Konya Parke Taşı Döşeme', 'konya-parke-tasi', 'Konya', 'Parke Taşı'],
            ['Konya Bordür Taşı Uygulama', 'konya-bordur-tasi', 'Konya', 'Bordür'],
        ];

        foreach ($sayfalar as [$h1, $slug, $sehir, $tip]) {
            SeoLanding::updateOrCreate(['slug' => $slug], [
                'baslik_h1' => $h1,
                'sehir' => $sehir,
                'urun_tipi' => $tip,
                'icerik' => "<p><strong>{$h1}</strong> alanında {$sehir} ve çevresinde uzman ekibimizle hizmet veriyoruz. 2010'dan bu yana edindiğimiz tecrübeyle, {$sehir} genelinde villa bahçelerinden fabrika sahalarına, kamu projelerinden site çevre düzenlemelerine kadar geniş bir yelpazede {$tip} uygulaması gerçekleştiriyoruz.</p><p>Doğru zemin hazırlığı, kaliteli malzeme ve titiz işçilikle uzun ömürlü zeminler oluşturuyoruz. Ücretsiz keşif ve teklif için bizimle iletişime geçin.</p>",
                'meta_title' => "{$h1} | Sekmen Zemin Tasarım",
                'meta_desc' => "{$sehir} {$tip} uygulaması. Ücretsiz keşif, profesyonel işçilik ve garanti. Sekmen Zemin Tasarım ile zeminleriniz güvende.",
                'durum' => 'yayin',
            ]);
        }
    }
}
