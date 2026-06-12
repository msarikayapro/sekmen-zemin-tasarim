<?php

namespace Database\Seeders;

use App\Models\Hizmet;
use Illuminate\Database\Seeder;

class HizmetSeeder extends Seeder
{
    public function run(): void
    {
        $hizmetler = [
            ['Parke Taşı Uygulama', 'architecture', 'Profesyonel ekiplerimizle her türlü zeminde kusursuz kilit parke ve taş döşeme işleri. Zemin sıkıştırmadan son temizliğe kadar anahtar teslim uygulama.'],
            ['Peyzaj & Çevre Düzenleme', 'park', 'Bahçe ve çevre düzenlemesiyle yaşam alanlarınıza estetik bir dokunuş. Yeşil alan, yürüyüş yolu ve dekoratif zemin tasarımı.'],
            ['Altyapı Çalışmaları', 'foundation', 'Zemin hazırlığı, kazı-dolgu ve drenaj sistemleri ile projelerinizin ömrünü uzatıyoruz. Doğru altyapı, kalıcı zeminin temelidir.'],
            ['Bordür & Yağmur Oluğu', 'straighten', 'Su tahliye sistemleri ve çevre sınırlama elemanları için teknik çözümler. Yolların ve alanların kenarlarını çerçeveliyoruz.'],
            ['Kilit Taşı Onarım & Bakım', 'build', 'Mevcut zeminlerinizdeki çökme, oynama ve bozulmaları onarıyor, uzun ömürlü bakım hizmeti sunuyoruz.'],
            ['Danışmanlık & Keşif', 'support_agent', 'Ücretsiz yerinde keşif, ölçüm ve malzeme danışmanlığı. Bütçenize ve projenize en uygun çözümü birlikte planlıyoruz.'],
        ];

        $sira = 0;
        foreach ($hizmetler as [$ad, $ikon, $aciklama]) {
            $sira++;
            Hizmet::updateOrCreate(
                ['slug' => slugify_tr($ad)],
                [
                    'ad' => $ad,
                    'ikon' => $ikon,
                    'aciklama' => $aciklama,
                    'sira' => $sira,
                    'durum' => 'yayin',
                    'meta_title' => $ad . ' | Sekmen Zemin Tasarım',
                    'meta_desc' => mb_substr($aciklama, 0, 155),
                ]
            );
        }
    }
}
