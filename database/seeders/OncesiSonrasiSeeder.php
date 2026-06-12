<?php

namespace Database\Seeders;

use App\Models\OncesiSonrasi;
use App\Models\Proje;
use Illuminate\Database\Seeder;

class OncesiSonrasiSeeder extends Seeder
{
    public function run(): void
    {
        $meram = Proje::where('slug', slugify_tr('Meram Villa Bahçe Uygulaması'))->first();

        $kayitlar = [
            ['Villa Girişi Dönüşümü', null, 1, $meram?->id],
            ['Bahçe Yürüyüş Yolu', null, 2, null],
            ['Otopark Zemini Yenileme', null, 3, null],
        ];

        foreach ($kayitlar as [$baslik, $_, $sira, $projeId]) {
            OncesiSonrasi::updateOrCreate(
                ['baslik' => $baslik],
                [
                    // Görseller müşteri tarafından panelden yüklenecek; şimdilik placeholder.
                    'oncesi_gorsel' => '',
                    'sonrasi_gorsel' => '',
                    'proje_id' => $projeId,
                    'sira' => $sira,
                    'durum' => 'yayin',
                ]
            );
        }
    }
}
