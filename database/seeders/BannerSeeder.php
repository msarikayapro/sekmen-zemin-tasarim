<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::updateOrCreate(
            ['baslik' => "Konya'nın güvenilir parke taşı uygulama firması"],
            [
                'gorsel' => '',
                'alt_baslik' => 'Estetik, Dayanıklılık ve Zanaatın Buluştuğu Nokta. Sekmen Zemin Tasarım ile her adımda kaliteyi hissedin.',
                'alt_metin' => 'Sekmen Zemin Tasarım hero görseli',
                'buton_yazi' => 'Teklif Al',
                'link' => '/iletisim',
                'sira' => 1,
                'durum' => 'yayin',
            ]
        );
    }
}
