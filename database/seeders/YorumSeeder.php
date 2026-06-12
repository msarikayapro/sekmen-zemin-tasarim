<?php

namespace Database\Seeders;

use App\Models\Yorum;
use Illuminate\Database\Seeder;

class YorumSeeder extends Seeder
{
    public function run(): void
    {
        $yorumlar = [
            ['Ahmet Yılmaz', 'Villa Sahibi', 'Villamızın bahçesi için Begonit uygulaması yaptırdık. İşçilik gerçekten muazzam, ekip çok titizdi. Teşekkürler Sekmen Zemin.', 5, true],
            ['Mehmet Demir', 'Şantiye Şefi', 'Fabrika sahamızın kilitli parke işini zamanında ve çok sağlam bir şekilde teslim ettiler. Ağır araç trafiğine rağmen hiç sorun yaşamadık.', 5, true],
            ['Ayşe Kaya', 'Mimar', 'Hızlı teklif süreci ve temiz çalışma. Projelerimde tekrar çalışmak isteyeceğim bir firma. Kesinlikle tavsiye ediyorum.', 5, true],
            ['Caner Öztürk', 'Müteahhit', "Konya'daki en dürüst ve işine sadık ekiplerden biri. Sözlerini tuttular, keşiften teslime kadar her şey planlandığı gibi ilerledi.", 5, false],
            ['Zeynep Aydın', 'Site Yöneticisi', 'Sitemizin çevre düzenlemesini Sekmen Zemin yaptı. Hem fiyat hem kalite açısından çok memnun kaldık.', 5, false],
            ['Hasan Çelik', 'İşletme Sahibi', 'İş yerimizin önünü Prizma taş ile döşediler. Görünüm harika oldu, müşterilerimizden çok olumlu tepki alıyoruz.', 4, false],
        ];

        $sira = 0;
        foreach ($yorumlar as [$ad, $unvan, $icerik, $puan, $oneCikan]) {
            $sira++;
            Yorum::updateOrCreate(
                ['ad' => $ad, 'icerik' => $icerik],
                [
                    'unvan' => $unvan,
                    'puan' => $puan,
                    'one_cikan' => $oneCikan,
                    'durum' => 'yayin',
                    'sira' => $sira,
                ]
            );
        }
    }
}
