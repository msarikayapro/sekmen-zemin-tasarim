<?php

namespace Database\Seeders;

use App\Models\Proje;
use App\Models\Urun;
use Illuminate\Database\Seeder;

class ProjeSeeder extends Seeder
{
    public function run(): void
    {
        $projeler = [
            ['Meram Villa Bahçe Uygulaması', 'konut', 'Meram / Konya', '2024', '250 m² Begonit parke taşı ile villa bahçesi ve giriş yolu uygulaması.', true, ['begonit', 'bordur']],
            ['Organize Sanayi Fabrika Sahası', 'ticari', 'Selçuklu / Konya', '2023', '1.500 m² kilitli parke ile ağır tonajlı araç trafiğine uygun fabrika sahası döşemesi.', true, ['kilitli', 'bordur']],
            ['Belediye Park ve Yürüyüş Alanı', 'kamu', 'Karatay / Konya', '2023', 'Antik ve bordür taşlarıyla kamuya açık park alanı ve yürüyüş yolları düzenlemesi.', true, ['antik', 'bordur', 'yagmur-olugu']],
            ['Modern İş Merkezi Girişi', 'ticari', 'Konya', '2024', 'Prizma model ile minimal ve prestijli iş merkezi giriş zemini.', false, ['prizma']],
            ['Özel Villa Havuz Çevresi', 'konut', 'Konya', '2024', 'Patara altıgen taş ile havuz kenarı ve bahçe yürüyüş yolu peyzaj uygulaması.', false, ['patara', 'naturalis']],
            ['Site Çevre Düzenlemesi', 'peyzaj', 'Selçuklu / Konya', '2022', '800 m² karma uygulama; site içi yollar, otopark ve yeşil alan düzenlemesi.', false, ['kilitli', 'begonit', 'bordur']],
        ];

        $sira = 0;
        foreach ($projeler as [$baslik, $tip, $konum, $tarih, $aciklama, $oneCikan, $urunSluglar]) {
            $sira++;
            $proje = Proje::updateOrCreate(
                ['slug' => slugify_tr($baslik)],
                [
                    'baslik' => $baslik,
                    'tip' => $tip,
                    'konum' => $konum,
                    'tarih' => $tarih,
                    'aciklama' => $aciklama,
                    'one_cikan' => $oneCikan,
                    'sira' => $sira,
                    'durum' => 'yayin',
                ]
            );

            $urunIdler = Urun::whereIn('slug', $urunSluglar)->pluck('id')->all();
            $proje->urunler()->syncWithoutDetaching($urunIdler);
        }
    }
}
