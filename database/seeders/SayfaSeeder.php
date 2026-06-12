<?php

namespace Database\Seeders;

use App\Models\Sayfa;
use Illuminate\Database\Seeder;

class SayfaSeeder extends Seeder
{
    public function run(): void
    {
        Sayfa::updateOrCreate(['anahtar' => 'home'], [
            'baslik' => 'Ana Sayfa',
            'meta_title' => "Sekmen Zemin Tasarım | Konya Parke Taşı Uygulama & Peyzaj",
            'meta_desc' => "Konya merkezli parke taşı uygulama ve peyzaj firması. 2010'dan beri 1.000.000 m²'yi aşkın uygulama. 28 taş modeli, ücretsiz keşif ve teklif.",
            'bloklar' => [
                'neden_baslik' => 'Neden Sekmen Zemin?',
                'neden_aciklama' => "Konya'da kilit parke taşı uygulamalarında liderliği hedefleyen firmamız, her projeyi bir sanat eseri titizliğiyle ele alır.",
                'seo_blok_baslik' => 'Neden Kilitparke?',
                'seo_blok_icerik' => "<p><strong>Kilit parke taşı</strong>, hem estetik hem de fonksiyonel açıdan dış mekanlar için en çok tercih edilen zemin kaplama yöntemidir. Özellikle Konya iklimi gibi değişken hava koşullarında, esnek yapısı sayesinde çatlama yapmaz ve su drenajına olanak sağlar.</p><p>Doğru bir <strong>kilit taşı uygulaması</strong>, sadece estetik değil, aynı zamanda mülkünüzün değerini artıran kalıcı bir yatırımdır. Sekmen Zemin olarak, zemin sıkıştırma işleminden dolguya kadar her aşamada profesyonel standartları uyguluyoruz.</p>",
            ],
        ]);

        Sayfa::updateOrCreate(['anahtar' => 'about'], [
            'baslik' => 'Hakkımızda',
            'meta_title' => 'Hakkımızda | Sekmen Zemin Tasarım',
            'meta_desc' => "2010'dan beri Konya merkezli parke taşı uygulama ve peyzaj firması. 1.000.000 m²'yi aşkın tamamlanmış uygulama tecrübesi.",
            'icerik' => "<p><strong>Sekmen Zemin Tasarım</strong> (eski adıyla Sekmen Yapı), 2010 yılından bu yana Konya merkezli olarak parke/kilit taşı uygulaması, peyzaj ve zemin çözümleri alanında hizmet vermektedir.</p>
<p>Apartman, site, villa, fabrika, çiftlik evi ve kamu mülkleri için altyapı, üstyapı ve peyzaj uygulamaları gerçekleştiriyoruz. Kuruluşumuzdan bu yana 800.000 m²'nin üzerinde uygulamayı başarıyla tamamladık.</p>
<p>Misyonumuz; estetik ile mühendislik dayanıklılığını birleştirerek, mekanlarınıza uzun ömürlü ve kaliteli zemin çözümleri sunmaktır. \"Teknoloji, dizayn ve estetik\" anlayışıyla her projeye zanaatkâr titizliğiyle yaklaşıyoruz.</p>",
            'bloklar' => [
                'misyon' => 'Estetik ve dayanıklılığı birleştirerek mekanlara değer katmak.',
                'vizyon' => "Konya ve çevre illerde parke taşı uygulamasında ilk tercih edilen marka olmak.",
            ],
        ]);

        Sayfa::updateOrCreate(['anahtar' => 'kvkk'], [
            'baslik' => 'KVKK Aydınlatma Metni',
            'meta_title' => 'KVKK Aydınlatma Metni | Sekmen Zemin Tasarım',
            'meta_desc' => 'Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni.',
            'icerik' => "<p>6698 sayılı Kişisel Verilerin Korunması Kanunu (\"KVKK\") uyarınca, Sekmen Zemin Tasarım olarak veri sorumlusu sıfatıyla, sizlere ait kişisel verileri aşağıda açıklanan amaçlar kapsamında işlemekteyiz.</p>
<p><strong>İşlenen Veriler:</strong> Ad-soyad, telefon, e-posta ve teklif formu aracılığıyla ilettiğiniz bilgiler.</p>
<p><strong>İşleme Amacı:</strong> Teklif taleplerinizin değerlendirilmesi, sizinle iletişime geçilmesi ve hizmetlerimizin sunulması.</p>
<p><strong>Haklarınız:</strong> KVKK'nın 11. maddesi kapsamında verilerinize ilişkin bilgi talep etme, düzeltilmesini veya silinmesini isteme haklarına sahipsiniz. Talepleriniz için info@sekmenzemintasarim.com adresine başvurabilirsiniz.</p>",
        ]);

        Sayfa::updateOrCreate(['anahtar' => 'cerez'], [
            'baslik' => 'Çerez Politikası',
            'meta_title' => 'Çerez Politikası | Sekmen Zemin Tasarım',
            'meta_desc' => 'Web sitemizde kullanılan çerezler hakkında bilgilendirme.',
            'icerik' => "<p>Web sitemiz, deneyiminizi iyileştirmek ve site trafiğini analiz etmek amacıyla çerezler kullanmaktadır.</p>
<p><strong>Zorunlu Çerezler:</strong> Sitenin temel işlevleri için gereklidir.</p>
<p><strong>Analitik Çerezler:</strong> Ziyaretçi davranışlarını anonim olarak analiz etmek için Google Analytics gibi araçlar kullanılabilir.</p>
<p>Tarayıcı ayarlarınızdan çerezleri istediğiniz zaman engelleyebilir veya silebilirsiniz.</p>",
        ]);
    }
}
