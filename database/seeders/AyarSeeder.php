<?php

namespace Database\Seeders;

use App\Models\Ayar;
use App\Models\PazarlamaAyari;
use Illuminate\Database\Seeder;

class AyarSeeder extends Seeder
{
    public function run(): void
    {
        $ayarlar = [
            'site_basligi'      => 'Sekmen Zemin Tasarım',
            'slogan'            => "Konya'nın güvenilir parke taşı uygulama firması",
            'kurulus_yili'      => '2010',
            'uygulama_m2'       => '1000000',
            'proje_sayisi'      => '800',
            'mutlu_musteri'     => '1000',
            'telefon'           => '0533 607 89 76',
            'telefon2'          => '0332 342 24 76',
            'whatsapp'          => '905336078976',
            'whatsapp_mesaj'    => 'Merhaba, parke taşı uygulaması hakkında bilgi almak istiyorum.',
            'email'             => 'info@sekmenzemintasarim.com',
            'adres'             => 'Yazır Mh. Canfeda Sk. No:16/A Selçuklu / Konya',
            'calisma_saatleri'  => 'Pazartesi - Cumartesi: 08:30 - 18:30',
            'harita_embed'      => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3138.0!2d32.49!3d37.92!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zS29ueWE!5e0!3m2!1str!2str!4v1700000000000',
            'sosyal_instagram'  => 'https://instagram.com/',
            'sosyal_facebook'   => 'https://facebook.com/',
            'sosyal_youtube'    => '',
            'logo'              => '',
            'logo_koyu'         => '',
            'favicon'           => '',
            'tema_renk'         => '#B6863E',
            'katalog_pdf'       => '',
            'hizmet_bolgeleri'  => 'Konya, Ankara, Antalya, Aksaray, Mersin, Denizli, Bursa, Eskişehir ve İç Anadolu geneli',
            'footer_aciklama'   => 'Konya merkezli firmamız, estetik ve dayanıklı zemin çözümleriyle mekanlarınıza değer katar. 2010\'dan beri parke taşı uygulama ve peyzaj alanında güvenle hizmet veriyoruz.',
        ];

        Ayar::topluKaydet($ayarlar);

        PazarlamaAyari::firstOrCreate([], [
            'meta_pixel_aktif' => false,
            'capi_aktif' => false,
            'event_mapping' => PazarlamaAyari::varsayilanEventMapping(),
        ]);
        PazarlamaAyari::temizle();
    }
}
