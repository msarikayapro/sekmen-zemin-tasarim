<?php

namespace Database\Seeders;

use App\Models\Sss;
use App\Models\SssSayfa;
use Illuminate\Database\Seeder;

class SssSeeder extends Seeder
{
    public function run(): void
    {
        // [soru, cevap, kategori, sira, [sayfa_anahtarlari] (boş = tüm sayfalar)]
        $sssler = [
            ['Hangi kalınlığı tercih etmeliyim? (6 cm vs 8 cm)', 'Genellikle yaya yolları, parklar ve bahçeler için 6 cm kalınlık yeterlidir. Ancak araç trafiğinin olduğu otopark veya site girişleri gibi alanlarda 8 cm kalınlığındaki taşlar tercih edilmelidir.', 'Kilitli Taş', 1, ['urun_detay', 'urun_kategori']],
            ['Uygulama öncesi zemin hazırlığı nasıl olmalı?', 'Zemin öncelikle stabilize edilmeli, üzerine ince bir kum tabakası (mastar kumu) serilerek tesviye edilmelidir. Doğru drenaj için eğim hesaplamaları uzman ekibimiz tarafından yapılır.', 'Döşeme', 2, ['urun_detay', 'hizmetler']],
            ['Taşlar zamanla yerinden oynar mı?', 'Kilitli parke taşları birbirine geçmeli yapısı ve kenar bordür uygulaması sayesinde yatay hareket etmez. Doğru sıkıştırma yapıldığında çökme veya oynama yapmaz.', 'Kilitli Taş', 3, ['urun_detay']],
            ['Nakliye ve sevkiyat yapıyor musunuz?', 'Evet. Konya merkez başta olmak üzere İç Anadolu ve çevre illere kendi araç filomuz ve anlaşmalı nakliye ile palet teslimat yapıyoruz. Hizmet bölgelerimiz için bizimle iletişime geçebilirsiniz.', 'Nakliye', 4, ['iletisim', 'ana_sayfa']],
            ['Uygulama işçiliği de yapıyor musunuz, yoksa sadece satış mı?', 'Hem ürün tedariği hem de anahtar teslim uygulama hizmeti veriyoruz. Keşif, zemin hazırlığı, döşeme ve son temizlik dahil tüm süreci profesyonel ekiplerimizle yürütüyoruz.', 'Genel', 5, []],
            ['Garanti veriyor musunuz?', 'Uyguladığımız her metrekare için işçilik ve malzeme garantisi sunuyoruz. Detaylar projeye göre teklif aşamasında netleştirilir.', 'Garanti/Bakım', 6, []],
            ['Ücretsiz keşif ve teklif alabilir miyim?', 'Elbette. Yerinde ücretsiz ölçüm ve zemin analizi yapıyor, bütçenize en uygun çözümü içeren detaylı teklifi sunuyoruz. Teklif formunu doldurarak veya WhatsApp\'tan bize ulaşabilirsiniz.', 'Genel', 7, ['ana_sayfa', 'iletisim']],
            ['Bordür uygulaması neden önemlidir?', 'Bordür, döşenen parke taşlarının yanal hareketini engelleyerek zeminin uzun ömürlü olmasını sağlar. Ayrıca su tahliyesini yönlendirir ve alanı estetik olarak çerçeveler.', 'Bordür', 8, ['urun_detay']],
            ['Peyzaj projeleri için danışmanlık veriyor musunuz?', 'Evet, bahçe ve çevre düzenlemesi projelerinizde malzeme seçiminden tasarıma kadar danışmanlık hizmeti sunuyoruz.', 'Peyzaj', 9, ['hizmetler']],
        ];

        foreach ($sssler as [$soru, $cevap, $kategori, $sira, $sayfalar]) {
            $sss = Sss::updateOrCreate(
                ['soru' => $soru],
                ['cevap' => $cevap, 'kategori' => $kategori, 'sira' => $sira, 'durum' => 'yayin']
            );

            $sss->sayfalar()->delete();
            foreach ($sayfalar as $anahtar) {
                SssSayfa::create(['sss_id' => $sss->id, 'sayfa_anahtar' => $anahtar]);
            }
        }
    }
}
