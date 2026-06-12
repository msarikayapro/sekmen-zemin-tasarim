<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Urun;
use Illuminate\Database\Seeder;

class UrunSeeder extends Seeder
{
    public function run(): void
    {
        $parke = Kategori::where('slug', 'parke-taslari')->first();
        $cevre = Kategori::where('slug', 'cevre-tamamlayici-elemanlar')->first();

        // Ortak varsayılan teknik değerler (parke grubu)
        $parkeRenk = ['Gri', 'Kırmızı', 'Füme', 'Antrasit', 'Mix'];
        $parkeKullanim = ['Yaya Yolu', 'Araç Yolu', 'Bahçe', 'Site İçi Yol', 'Otopark'];

        // [ad, kategori, one_cikan, ebat_en, ebat_boy, kalinlik, m2_adet, palet, aciklama]
        $urunler = [
            // --- Parke Taşları ---
            ['Ani', 'A', false, '20 cm', '16,5 cm', '6 / 8 cm', '36 Adet', '10 - 12 m²', 'Klasik kilitli formuyla her ölçekte projeye uyum sağlayan, yüksek dayanımlı standart parke taşı modeli.'],
            ['Azure', 'A', false, '20 cm', '10 cm', '6 / 8 cm', '50 Adet', '10 m²', 'İnce dikdörtgen hatlarıyla modern yürüyüş yolları ve teras uygulamaları için ideal estetik model.'],
            ['Antara', 'A', false, '24 cm', '16 cm', '6 / 8 cm', '26 Adet', '11 m²', 'Geniş yüzeyi ve kolormix renk seçenekleriyle dekoratif zeminlerde tercih edilen şık model.'],
            ['Alinda', 'A', false, '20 cm', '20 cm', '6 / 8 cm', '25 Adet', '10 m²', 'Kare formuyla sade ve düzenli bir görünüm sunan, modern mimariyle uyumlu parke taşı.'],
            ['Antik', 'A', true, '16 cm', '16 cm', '6 cm', '39 Adet', '10 m²', 'Eskitme (tumbled) yüzeyiyle tarihi ve nostaljik dokular yaratan prestijli antik seri.'],
            ['Assos', 'A', false, '21 cm', '14 cm', '6 / 8 cm', '34 Adet', '11 m²', 'Doğal taş görünümünü modern üretim teknikleriyle birleştiren dayanıklı döşeme modeli.'],
            ['Baklava', 'A', false, '20 cm', '12 cm', '6 cm', '42 Adet', '10 m²', 'Baklava dilimi geometrisiyle hareketli ve dekoratif zemin desenleri oluşturan model.'],
            ['Begonit', 'A', true, '20 cm', '16,5 cm', '6 / 8 cm', '36 Adet', '10 - 12 m²', 'Klasik görünüm ve modern dayanıklılığı birleştiren, villa bahçelerinin en çok tercih edilen modeli.'],
            ['Color Mix', 'A', false, '20 cm', '16,5 cm', '6 / 8 cm', '36 Adet', '10 - 12 m²', 'Birden fazla rengin uyum içinde harmanlandığı, canlı ve karakterli zeminler için özel renk seti.'],
            ['İkonia', 'A', false, '30 cm', '30 cm', '6 cm', '11 Adet', '10 m²', 'Büyük kare ebadıyla geniş alanlarda ferah ve modern bir görünüm sunan plaka model.'],
            ['Kilitli', 'A', true, '20 cm', '16,5 cm', '6 / 8 cm', '36 Adet', '10 - 12 m²', 'Endüstriyel güç ve pratik uygulama. Yüksek yüklere karşı mükemmel kilit direnci sağlayan klasik model.'],
            ['Likya', 'A', false, '18 cm', '12 cm', '6 cm', '46 Adet', '10 m²', 'İnce dokusu ve düzgün hatlarıyla butik bahçe ve yürüyüş yolları için zarif çözüm.'],
            ['Limonluk', 'A', false, '20 cm', '20 cm', '6 cm', '25 Adet', '10 m²', 'Bahçe ve sera çevreleri için tasarlanmış, kaymaz yüzeyli pratik döşeme modeli.'],
            ['Misya', 'A', false, '20 cm', '16,5 cm', '4 cm', '36 Adet', '12 m²', '4 cm inceliğiyle yaya yoğun bölgeler ve teraslarda hafif ve ekonomik çözüm sunan model.'],
            ['Myra', 'A', false, '21 cm', '14 cm', '6 / 8 cm', '34 Adet', '11 m²', 'Doğal yüzey dokusu ve sıcak tonlarıyla peyzaj projelerine değer katan model.'],
            ['Naturalis', 'A', false, '20 cm', '15 cm', '6 cm', '33 Adet', '10 m²', 'Doğal taş görünümlü yüzeyiyle organik mekan tasarımlarının vazgeçilmezi.'],
            ['Papyon', 'A', false, '22 cm', '11 cm', '6 / 8 cm', '40 Adet', '11 m²', 'Papyon formuyla birbirine geçen, dekoratif ve sağlam kilit yapısına sahip model.'],
            ['Patara', 'A', true, '20 cm', '17,3 cm', '6 / 8 cm', '34 Adet', '11 m²', 'Altıgen formuyla modern peyzajların ikonik tercihi; estetik ve dayanıklılığı bir arada sunar.'],
            ['Perge', 'A', false, '24 cm', '16 cm', '6 / 8 cm', '26 Adet', '11 m²', 'Geniş yüzey ve net hatlarıyla kamu ve ticari projelerde sıkça kullanılan güçlü model.'],
            ['Petek', 'A', false, '20 cm', '17,3 cm', '6 / 8 cm', '34 Adet', '11 m²', 'Altıgen petek deseniyle hareketli ve göz alıcı zeminler oluşturan klasik model.'],
            ['Prizma', 'A', true, '20 cm', '10 cm', '6 / 8 cm', '50 Adet', '10 m²', 'Keskin hatları ve minimal formuyla modern mimari projelerin vazgeçilmez modeli.'],
            ['Truva', 'A', false, '24 cm', '16 cm', '6 / 8 cm', '26 Adet', '11 m²', 'Sağlam yapısı ve geniş yüzeyiyle ağır trafik alanlarında uzun ömür sunan model.'],
            ['Sardes', 'A', false, '21 cm', '14 cm', '6 / 8 cm', '34 Adet', '11 m²', 'Doğal renk geçişleri ve dokulu yüzeyiyle prestijli mekanlara estetik bir dokunuş.'],

            // --- Çevre & Tamamlayıcı Elemanlar ---
            ['Bordür', 'B', true, '50 cm', '15 / 20 cm', '30 cm', '2 Adet/mt', '—', 'Yol ve yaya kenarlarını çerçeveleyen, su tahliyesini yönlendiren yüksek dayanımlı beton bordür.'],
            ['Yağmur Oluğu', 'B', false, '50 cm', '20 cm', '8 cm', '2 Adet/mt', '—', 'Yüzey sularını kontrollü tahliye eden, zemin ömrünü uzatan fonksiyonel oluk elemanı.'],
            ['Merdiven', 'B', false, '100 cm', '35 cm', '15 cm', '1 Adet/basamak', '—', 'Bahçe ve peyzaj alanları için kaymaz yüzeyli, dayanıklı prefabrik beton merdiven basamağı.'],
            ['Kent Mobilyası', 'B', false, 'Değişken', 'Değişken', '—', '—', '—', 'Park bankı, çöp kovası ve saksı gibi kentsel alanları tamamlayan dekoratif beton elemanlar.'],
            ['Ateş Çukuru', 'B', false, '80 cm', '80 cm', '30 cm', '1 Adet', '—', 'Bahçe ve villa teraslarında sıcak buluşma alanları oluşturan dekoratif ateş çukuru ünitesi.'],
        ];

        $sira = 0;
        foreach ($urunler as $u) {
            [$ad, $kat, $oneCikan, $en, $boy, $kalinlik, $m2, $palet, $aciklama] = $u;
            $sira++;

            $cevreMi = $kat === 'B';

            $urun = Urun::updateOrCreate(
                ['slug' => slugify_tr($ad)],
                [
                    'ad' => $ad,
                    'aciklama' => $aciklama,
                    'ebat_en' => $en,
                    'ebat_boy' => $boy,
                    'kalinlik' => $kalinlik,
                    'm2_adet' => $m2,
                    'palet_bilgi' => $palet,
                    'renk_secenekleri' => $cevreMi ? ['Gri', 'Antrasit'] : $parkeRenk,
                    'kullanim_alanlari' => $cevreMi
                        ? ['Yol Kenarı', 'Peyzaj', 'Çevre Düzenleme']
                        : $parkeKullanim,
                    'dayanim' => 'Yüksek basınç dayanımı (BS EN 1338 uyumlu)',
                    'don_direnci' => 'Dona dayanıklı (F1 sınıfı)',
                    'one_cikan' => $oneCikan,
                    'sira' => $sira,
                    'durum' => 'yayin',
                    'meta_title' => $ad . ' Parke Taşı | Sekmen Zemin Tasarım',
                    'meta_desc' => mb_substr($aciklama, 0, 155),
                ]
            );

            // Kategori ataması (many-to-many)
            $kategoriId = $cevreMi ? $cevre?->id : $parke?->id;
            if ($kategoriId) {
                $urun->kategoriler()->syncWithoutDetaching([$kategoriId]);
            }
        }
    }
}
