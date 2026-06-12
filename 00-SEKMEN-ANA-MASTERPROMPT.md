# SEKMEN ZEMİN TASARIM — ANA MASTERPROMPT (KONSOLİDE)

> **Bu dosya nedir?**
> Sekmen Zemin Tasarım web projesinin **tek kaynaklı ana planlama ve yürütme dosyasıdır.** Daha önce ayrı ayrı tutulan tüm planlama, brief, rakip analizi, müşteri cevapları, admin panel, tasarım ve deploy bilgilerini tek yerde birleştirir. Hiçbir detay atlanmamıştır.
>
> **İş akışı:** Bu masterprompt → **Google Stitch** (UI/arayüz tasarımı) → **Claude Code** (kod + veritabanı + yayın).
>
> **Ek dosyalar (bu dosyanın parçaları — her biri burada da özetlenir):**
> 1. `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md` → **Kurulumda ilk okunacak, kesinleşmiş site & panel özellik listesi (kodlamanın anayasası).**
> 2. `02-SEKMEN-ADMIN-PANEL.md` → Admin panelin tam modül/alan/yetki detayı.
> 3. `03-SEKMEN-TASARIM-RENK-REHBERI.md` → Renk paleti, gradient, animasyon ve etkileşim sistemi.
> 4. `04-LARAVEL-CPANEL-DEPLOY-ANAYASASI.md` → Paylaşımlı hosting (cPanel/Turhost) deploy & geliştirme kuralları.
>
> **Hazırlayan:** Mustafa Sarıkaya — ReklamPro (Konya)
> **Sürüm:** Master v3 (konsolide) · **Tarih:** 12.06.2026
> **Müşteri:** Sekmen Zemin Tasarım (eski: Sekmen Yapı) · İletişim: Süleyman Bey
> **Yeni alan adı:** www.sekmenzemintasarim.com · (alternatif: sekmen.tr)
> **Kaynak site:** www.sekmenyapi.com → tamamen 301 ile yönlendirilecek

---

## ⚡ 0. ÖNCE OKU — KODLAMA İÇİN KRİTİK İLKE

**Bu projede backend ve frontend tarafında sonradan çalışmayan hiçbir kısım kalmamalıdır.** Bunun için kodlamaya başlamadan önce `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md` dosyası **baştan sona okunur.** O dosyada listelenen tüm site ve admin panel özellikleri:

- **Veritabanı şeması bu özelliklere göre** kurulur (eksik tablo/alan bırakılmaz).
- **Backend (model, controller, route, policy, migration)** bu özelliklere göre yazılır.
- **Frontend (sayfa, bileşen, form, panel ekranı)** bu özelliklere göre kodlanır ve **gerçekten backend'e bağlanır** — placeholder/çalışmayan buton bırakılmaz.
- Her admin panel özelliği için **hem arayüz hem veri katmanı hem de frontend yansıması** (sitede görünen yer) eksiksiz kurulur.

> **Kural:** Panelde "Öncesi/Sonrası ekle" diyorsa → DB'de tablo, controller'da CRUD, sitede gösterim bileşeni **üçü birden** olacak. Yarım özellik = hata.

---

## 1. PROJE ÖZETİ VE HEDEF

Konya merkezli firma, parke/kilit taşı uygulamaları ve peyzaj/zemin çözümleri alanında hizmet veriyor. **"Sekmen Yapı"** markasından **"Sekmen Zemin Tasarım"** markasına geçiş yapılıyor. Amaç; eski statik siteden modern, **yönetim panelli (CMS)**, **SEO odaklı**, **mobil öncelikli** ve teklif/lead toplamaya odaklı yeni bir siteye geçmek. Satış değil, **teklif/iletişim odaklı dönüşüm.**

### Proje Künyesi

| Alan | Bilgi |
|------|-------|
| Marka | Sekmen Zemin Tasarım (eski: Sekmen Yapı) |
| Müşteri iletişim | Süleyman Bey |
| Sektör | Parke/kilit taşı satış + uygulama, peyzaj / çevre düzenleme, zemin tasarımı |
| Konum / hizmet bölgesi | Konya merkezli (geniş hizmet bölgesi — bkz. §4 müşteri cevabı) |
| Yeni alan adı | www.sekmenzemintasarim.com (alternatif: sekmen.tr) |
| Kaynak site | www.sekmenyapi.com → 301 ile yönlendirilecek, Google değeri korunacak |
| Yönetim paneli | Var (CMS/admin panelli — premium paket çekirdeği) |
| Yaklaşım | Mobil öncelikli, SEO odaklı, tam yönetilebilir |
| Ajans / iletişim kimliği | Mustafa Sarıkaya — ReklamPro (Konya) |
| İş akışı | Planlama (bu masterprompt) → Google Stitch (UI) → Claude Code (kod + yayın) |

### Birincil iş hedefleri (sitenin başarı kriterleri)
1. Ziyaretçiyi **teklif/iletişim formuna** veya **WhatsApp'a** yönlendirmek (dönüşüm).
2. Ürün portföyünü (28 parke taşı modeli) profesyonel ve aranabilir biçimde sergilemek.
3. Tamamlanmış projelerle (referanslar) güven inşa etmek.
4. Eski sitenin Google değerini **301 yönlendirmelerle korumak** (SEO geçişi).
5. Müşterinin içeriği teknik bilgi olmadan **kendi panelinden (çoğunlukla mobilden)** yönetebilmesi.

---

## 2. MÜŞTERİ CEVAPLARI (Süleyman Bey — alındı 12.06.2026)

Aşağıdaki kararlar müşteriden teyitlidir ve plana işlenmiştir.

| # | Konu | Karar |
|---|------|-------|
| 1 | **Slogan / ana başlık** | Hazır metin yok; "Konya'nın güvenilir parke taşı uygulama firması" örneğini uygun buldu. → **Aksiyon: ReklamPro yazıp onaylatacak.** |
| 2 | **Hizmet bölgesi** | Ankara, Antalya, Aksaray, Mersin, Konya + İç Anadolu geneli + Denizli, Bursa, Eskişehir |
| 3 | **Rakamlarla biz** | Kuruluş **2010** · Tamamlanan: **800.000–1.000.000 m²** uygulama |
| 4 | **Ürünler / Hizmetler menüsü** | **Ayrı ayrı.** Ürünler = parke taşı modelleri · Hizmetler = uygulama işleri |
| 5 | **Ürün sayfası içeriği** | Tümü istenecek: foto galerisi, ölçüler (en/boy/kalınlık), renk seçenekleri, m²/palet bilgisi, kullanım alanları, teknik özellikler (dayanım, don direnci) |
| 6 | **Ürün sayfasından teklif** | **Evet.** Her üründe "Bu ürün için teklif iste" → form otomatik ürün adıyla gelir |
| 7 | **Öncesi/Sonrası** | **Evet** isteniyor; müşterinin elinde hazır örnek görseller mevcut |
| 8 | **Müşteri yorumları** | **Evet**, sitede gösterilsin |

### Açık / bekleyen kararlar
- [ ] **Slogan metni** ReklamPro tarafından yazılıp onaya sunulacak
- [ ] **Rakam sunumu:** "800.000+ m²" mı, "1.000.000 m²" yuvarlak mı? (öneri netleşince işaretle)
- [ ] **Marka kapsamı:** Sadece kilit/parke taşı mı, yoksa epoksi/beton baskı/peyzaj da mı?
- [ ] **Üretim mi, uygulama/satış mı?** → Ürün sayfası dilini etkiler ("üretiyoruz" vs "uyguluyoruz")
- [ ] **Fiyat gösterimi:** Sitede fiyat olacak mı, yoksa sadece teklif üzerinden mi? (öneri: teklif odaklı)
- [ ] **Logo / kurumsal kimlik:** Hazır mı, yoksa tasarım kapsama dahil mi?
- [ ] **Color Mix:** Bir model mi yoksa renk/desen varyantı mı?
- [ ] **Blog ve SSS sayfaları** ilk fazda mı, sonraya mı?
- [ ] **Çok dillilik:** Bilinçli olarak ertelendi (gelecek upsell) — sadece TR.

---

## 3. HEDEF KİTLE / PERSONALAR

| Persona | İhtiyaç | Sitede ne arar |
|---|---|---|
| **Bireysel müşteri** (villa/bahçe sahibi) | Bahçesine/girişine parke taşı | Modeller, görseller, "nasıl görünür", fiyat/teklif |
| **Müteahhit / inşaat firması** | Site/apartman projesi için toplu zemin | Teknik özellik, m² kapasite, referans projeler, hızlı teklif |
| **Kamu / kurumsal alıcı** | İhale, kaldırım, peyzaj | Kurumsal güven, belgeler, tamamlanan kamu işleri, katalog |
| **Peyzaj mimarı / bayi** | İş ortağı / tedarik | Ürün kataloğu (PDF indir), teknik detay, iletişim |

**Tasarım kararı:** Ana CTA her zaman "Teklif Al / İletişim" olmalı; her persona 2 tıkta teklife ulaşabilmeli.

---

## 4. MARKA & GÖRSEL KİMLİK YÖNÜ (Stitch için kritik)

> Renk, gradient, tipografi ve animasyon sisteminin **tam detayı** `03-SEKMEN-TASARIM-RENK-REHBERI.md` dosyasındadır. Burada özet verilir.

### Konumlandırma
- **Marka tonu:** Güven veren, kurumsal ama erişilebilir; "zanaat + mühendislik" hissi. Lüks-villa estetiği ile endüstriyel dayanıklılık arasında denge. Aşırı süslü değil, net ve modern.
- **Hedef his:** Ziyaretçi "bu firma işini biliyor ve temiz iş çıkarıyor" hissetmeli.

### Görsel yön (özet — detay rehberde)
- **Renk yönü:** Koyu temelli, **gold/altın vurgulu**, modern lüks. Logodan türetilmiş palet: antrasit/kömür zemin (`#0A0A0A` / `#13161A`), gold-bronz vurgu (`#B6863E` / `#C9962E`), kırık beyaz metin (`#F5F2EC` / `#F5F3EE`).
  > **Not:** İki renk rehberi belgesi mevcut (logodan pipetlenmiş paletler). Claude Code aşamasında **`03` dosyasındaki birincil palet (kömür + gold + krem)** esas alınır; ikinci rehber alternatif ton seti olarak korunur.
- **Tipografi:** Başlıklar için güçlü, geniş harf aralıklı sans-serif (**Poppins** / Inter / Montserrat); gövde için okunaklı nötr sans-serif. ReklamPro stil dili Poppins ile uyumlu.
- **Görsel dili:** Bol gerçek proje fotoğrafı (uygulanmış parke taşı zeminleri), yakın çekim doku görselleri, geniş "öncesi/sonrası" alanları. Stok fotoğraftan kaçın; firmanın kendi işleri kahraman.
- **UI hissi:** Modern, ferah; koyu zemin + gold vurgu; yumuşak animasyon (hover kalkışı, shine sweep, scroll reveal). Mobil öncelikli.
- **Logo:** Yeni "Sekmen Zemin Tasarım" logosu — açık ve koyu zemin versiyonu gerekli.
- **Marka motifi:** Logodaki zemin/kaldırım perspektif motifi hero arka planında ince çizgi animasyonu olarak yeniden kullanılabilir.

---

## 5. SİTE HARİTASI (SAYFA YAPISI)

> Stitch için ana iskelet. Her satır bir sayfa/route. Müşteri kararı: **Ürünler ve Hizmetler ayrı menüler.**

```
/                         Ana Sayfa
/hakkimizda               Hakkımızda (kurumsal hikaye, 2010'dan beri, vizyon)
/urunler                  Ürünler — kategori/grid listeleme (28 taş çeşidi)
/urunler/[slug]           Ürün Detay (her parke taşı modeli)
/hizmetler                Hizmetler (uygulama, peyzaj, altyapı vb. — ürünlerden ayrı)
/projeler                 Projeler / Referanslar — filtreli galeri + öncesi/sonrası
/projeler/[slug]          Proje Detay (opsiyonel — büyük işler için)
/galeri                   Galeri (saha/uygulama fotoğrafları)
/katalog                  Katalog (PDF indir / görüntüle)
/iletisim                 İletişim + teklif formu + harita
/blog                     Blog (SEO için — opsiyonel/faz 2)
/blog/[slug]              Blog yazı detay
```

**SEO Landing sayfaları (şablon bazlı, panelden yönetilebilir):**
`/konya-kilit-tasi`, `/konya-parke-tasi`, `/konya-bordur-tasi`, `/konya-andezit` vb. — şehir+ürün kombinasyonları. Her biri ayrı meta + özgün uzun içerik (bkz. §10 rakip analizi).

**Yasal/footer sayfaları:** KVKK Aydınlatma Metni, Çerez Politikası.

---

## 6. NAVİGASYON YAPISI

**Üst menü (header):**
`Ana Sayfa · Kurumsal (Hakkımızda, SSS) · Ürünler ▾ · Hizmetler · Projeler · İletişim`
- Sağ üstte: **"Teklif Al"** vurgu butonu + telefon numarası tıklanabilir.
- Header sticky (kaydırınca üstte sabit, küçülerek).
- **Ürünler ▾** dropdown: parke taşı kategorileri.

**Mobil menü:** Hamburger; tam ekran açılır; en altta sabit "Teklif Al" + WhatsApp butonu.

**Footer:**
- Sütun 1: Marka logo + kısa açıklama + sosyal medya
- Sütun 2: Hızlı linkler (sayfalar)
- Sütun 3: Ürün kategorileri
- Sütun 4: İletişim (adres, telefon, e-posta, çalışma saatleri)
- Alt bar: Telif + KVKK + Çerez linkleri
- **Sabit/floating WhatsApp butonu** (her sayfada sağ alt köşe).

---

## 7. SAYFA SAYFA BÖLÜM (SECTION) PLANI

> Stitch'e her sayfanın bölümlerini bu sırayla ver.

### 7.1 ANA SAYFA
1. **Hero** — tam genişlik etkileyici uygulama görseli/slider, başlık (slogan), alt başlık, iki buton: **Teklif Al** + **Ürünleri İncele**. Üstte sade menü + telefon/WhatsApp. Konya vurgusu.
2. **Rakamlarla Biz / Güven şeridi** — kuruluş 2010, tamamlanan ~800.000–1.000.000 m², proje sayısı, mutlu müşteri (sayaç animasyonu).
3. **Öne çıkan ürün kategorileri / ürünler** — 4–8 taş çeşidi kart grid (görsel + isim + "İncele") → "Tüm Ürünler".
4. **Öne çıkan / Süreç hizmetleri** — ikon + 3–4 hizmet (uygulama, peyzaj, altyapı, bordür).
5. **Neden Sekmen?** — 3–4 avantaj (kalite, tecrübe, garanti, zamanında teslim). "Neden Sekmen / Neden Kilitparke" eğitici blok (rakipten ders, SEO için uzun metin).
6. **Öncesi/Sonrası** — karşılaştırma bölümü (müşterinin hazır görselleri var).
7. **Öne çıkan projeler** — son referanslardan 3–6 görsel (galeriye link).
8. **Süreç** — "Nasıl çalışıyoruz?" 4 adım (Keşif → Teklif → Uygulama → Teslim) görselli timeline.
9. **Müşteri yorumları** — gerçek yorumlar (panelden yönetilir).
10. **CTA bandı** — "Ücretsiz keşif ve teklif alın" + gömülü hızlı teklif formu/buton/telefon.
11. **Footer.**

### 7.2 HAKKIMIZDA
Kurumsal hikaye (2010'dan beri), misyon/vizyon, ekip/üretim görselleri, **belgeler/sertifikalar** (güven unsuru), rakamlar, zaman çizelgesi (opsiyonel).

### 7.3 ÜRÜNLER (Liste)
- Filtre/kategori sekmeleri (Tümü / Parke Taşları / Çevre & Tamamlayıcı Elemanlar).
- Grid kartlar: görsel + ürün adı + kısa etiket (ebat/tip) + "Detay/İncele".
- Hover'da görsel zoom + lightbox imkânı.
- Mobilde 2 kolon, masaüstünde 3–4 kolon.
- 28 çeşit listesi §8'den beslenir.

### 7.4 ÜRÜN DETAY
- Büyük görsel galerisi (lightbox + thumbnail).
- Ürün adı, açıklama.
- **Teknik özellikler tablosu:** ebat (en/boy/cm), kalınlık, m²'deki adet / palet bilgisi, renk seçenekleri, kullanım alanı (yaya yolu, araç yolu, bahçe, havuz kenarı...), dayanım/don direnci/sınıf.
- **Video alanı** (ürün tanıtım/uygulama videosu varsa).
- **"Bu ürün için teklif al"** butonu → form ürün adını otomatik taşır.
- İlgili/benzer ürünler (çapraz link).
> **Fark (rakip analizinden):** Rakiplerde ürünlerde sadece görsel+isim var; teknik detay yok. Biz teknik özellik + kullanım alanı ekleyerek farklılaşıyoruz.

### 7.5 HİZMETLER
Her hizmet için ikon/görsel + açıklama: parke taşı uygulaması/döşeme, bordür/kaldırım, altyapı/üstyapı (kazı/dolgu/drenaj), peyzaj/çevre düzenleme, danışmanlık, (kapsam netleşirse: epoksi/beton baskı). Her hizmetin altında "Teklif Al".

### 7.6 PROJELER / REFERANSLAR
- **Filtrelenebilir galeri** — tip: konut / kamu / ticari / peyzaj (villa bahçesi, site/apartman, otopark, yürüyüş yolu, havuz kenarı, kamu/belediye).
- **İki sekme ayrımı (rakipten ilham):** "Tamamlanan Projeler" + "Kurumsal/Kamu Referansları".
- Her proje: kapak görseli + (opsiyonel) konum/yıl + galeri lightbox + kullanılan taş çeşitleri (ürün kataloğuyla bağlantı).
- **Öncesi/Sonrası** karşılaştırması.
- Mevcut sitedeki 24+ referans görseli içerik envanteri olarak taşınacak.

### 7.7 GALERİ / KATALOG
- Galeri: saha/uygulama fotoğrafları (toplu).
- Katalog: PDF görüntüleme + **indirme butonu** (header'da sabit erişim). İndirme öncesi opsiyonel mini form (ad+telefon = lead toplama).

### 7.8 İLETİŞİM
- Teklif/iletişim formu (bkz. §11).
- Adres, telefon, e-posta, çalışma saatleri.
- Google Harita (embed) — net adres = yerel SEO sinyali.
- WhatsApp hızlı erişim butonu.

---

## 8. ÜRÜN KATALOĞU — 28 TAŞ ÇEŞİDİ (GÜNCEL)

Müşteriden gelen güncel liste. Ürünler sayfasında kart/grid olarak listelenecek; her birinin **görseli + adı + (varsa) ebat/açıklama** alanı olacak.

| No | Taş Adı | No | Taş Adı |
|----|---------|----|---------|
| 1 | Ani | 15 | Likya |
| 2 | Azure | 16 | Limonluk |
| 3 | Antara | 17 | Merdiven |
| 4 | Alinda | 18 | Misya 4 cm |
| 5 | Antik | 19 | Myra |
| 6 | Assos | 20 | Naturalis |
| 7 | Ateş Çukuru | 21 | Papyon |
| 8 | Baklava | 22 | Patara |
| 9 | Begonit | 23 | Perge |
| 10 | Bordür | 24 | Petek |
| 11 | Color Mix | 25 | Prizma |
| 12 | İkonia | 26 | Truva |
| 13 | Kent Mobilyası | 27 | Yağmur Oluğu |
| 14 | Kilitli | 28 | Sardes |

### Önerilen Kategorilendirme (müşteri onayı bekliyor)
**A) Parke Taşları (klasik döşeme modelleri):** Ani, Azure, Antara, Alinda, Antik, Assos, Baklava, Begonit, Color Mix, İkonia, Kilitli, Likya, Limonluk, Misya 4 cm, Myra, Naturalis, Papyon, Patara, Perge, Petek, Prizma, Truva, Sardes
**B) Çevre & Tamamlayıcı Elemanlar:** Bordür, Yağmur Oluğu, Merdiven, Kent Mobilyası, Ateş Çukuru

> **Netleşecek:** "Color Mix" model mi/varyant mı; kategori isimleri ve atamaları; her ürün için yüksek çözünürlüklü görsel + ebat bilgisi.
> **Not:** Ürün bir kategoriye değil **birden fazla kategoriye** atanabilir (many-to-many) — bkz. admin panel.

---

## 9. FORMLAR & DÖNÜŞÜM (LEAD)

### Teklif / İletişim Formu alanları
- Ad Soyad *(zorunlu)*
- Telefon *(zorunlu)*
- E-posta
- İl/İlçe (opsiyonel)
- İlgilenilen ürün/hizmet (dropdown — ürün detaydan otomatik dolar)
- Yaklaşık alan (m²) — opsiyonel
- Proje açıklaması / Mesaj
- (Opsiyonel) Fotoğraf yükleme — alanın mevcut hali
- KVKK onay kutusu *(zorunlu)*

### Davranış gereksinimleri (Claude Code için)
- Spam koruması (honeypot + opsiyonel reCAPTCHA/Turnstile) + sunucu tarafı doğrulama.
- Form gönderimi **panele "Talep/Lead" olarak düşmeli** + bildirim e-postası gitmeli.
- Başarı/hata durumu kullanıcıya net gösterilmeli (teşekkür ekranı).
- **WhatsApp ön-doldurulmuş mesaj** linki (ürün adı dahil) her ürün/CTA'da.
- Telefon numaraları `tel:` linkli, mobilde tıkla-ara.
- Sabit (sticky) WhatsApp butonu (her sayfada, özellikle mobilde).

---

## 10. RAKİP ANALİZİ (özet — aksiyona dönük)

İki rakip incelendi: **Yaşam Peyzaj (ankarakilittasiyp.com)** ve **Yiğit Yapı / Belbeton** tipi WP siteleri.

### Alınacak iyi fikirler
1. **Sürekli görünür WhatsApp + telefon CTA** → tüm sayfalara (header, içerik arası, footer).
2. **İlçe/şehir bazlı yerel SEO içeriği** → "Konya [ilçe] kilit taşı / zemin kaplama" (Selçuklu, Meram, Karatay...) + hizmet illeri. Şehir+ürün landing sayfaları.
3. **Sade, net ürün kategori yapısı** → 28 çeşidi menüye bölerken referans; "3 boyutlu/dekoratif" gibi görsel satan başlıklar öne.
4. **"Neden Kilitparke / Neden Sekmen" eğitici blok** → güven + SEO uzun metin.
5. **Her ürün/landing sayfasında uzun özgün SEO metni** (3–4 paragraf: üretim tekniği, kullanım, dayanıklılık).
6. **Sabit teklif/iletişim bloğu + WhatsApp balonu** (Joinchat tarzı).
7. **Çapraz hizmet linkleme** (her ürün altında diğer ürünlere link).
8. **Header'da sabit PDF katalog indir** butonu (lead aracı).
9. **Net adres + Google Maps** (yerel SEO sinyali).
10. **Referansların ikiye ayrılması:** "Tamamlanan Projeler" + "Kurumsal/Kamu Referansları".

### Sekmen'i öne geçirecek farklılaştırıcılar (rakipte yok, bizde premium)
| Özellik | Rakip | Sekmen Fırsatı |
|---|---|---|
| İçerik yönetimi | Elle güncellenen statik | **Admin panel** ile tam yönetim |
| Portföy | Sadece slider | **Filtrelenebilir galeri + öncesi/sonrası** |
| Sosyal kanıt | Yok | **Google yorumları + referans bölümü** |
| Teklif formu | Sadece iletişim sayfasında | **Ana sayfada gömülü hızlı teklif formu** |
| Konum | Footer'da "Ankara" | **Net adres + Google Maps gömme** |
| Ürün bilgisi | Sadece görsel+isim | **Teknik özellik + kullanım alanı + video** |

### Kaçınılacak hatalar (rakibin zayıf yönleri)
- Generic WP teması/Slider Revolution → bizde premium koyu+gold modern tasarım.
- **Sahte/çalışmayan dil seçenekleri** (footer'da FR/DE `#`) → çok dillilik bizde gerçek upsell, sahte konmaz.
- **Boş sosyal medya linkleri** (`#`) ve **hatalı kodlanmış e-posta** → bizde temiz, çalışan entegrasyonlar.
- Footer'da tekrar eden placeholder metin → içerik kontrolü titiz.
- Mobil menüde kırık linkler → QA ile önlenecek.

---

## 11. YÖNETİM PANELİ (ADMIN) — ÖZET

> **Tam detay:** `02-SEKMEN-ADMIN-PANEL.md`. Kesinleşmiş özellik listesi (kurulumda okunacak): `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md`.

**Temel prensip:** Panel çoğunlukla **mobilden** yönetilecek; bir "yönetim yazılımı" gibi değil, bir **mobil uygulama (app)** gibi hissettirmeli. Dashboard = aksiyon ekranı (büyük dokunmatik butonlar, bildirim rozetleri), rapor ekranı değil. PWA opsiyonu (öneri: evet).

**Çok kullanıcılı + yetki seviyeli:** Admin (tam yetki) / Editör (içerik ekle-düzenle, kullanıcı yönetimi ve kritik ayarlar yok). Yetkiye göre dinamik dashboard.

**Modüller (özet):**
1. Dashboard (aksiyon odaklı)
2. Ürün/Taş Kataloğu (28 çeşit + video + çoklu galeri + many-to-many kategori + sürükle-bırak sıralama)
3. Kategori Yönetimi
4. Projeler / Referanslar (öncesi/sonrası dahil)
5. İçerik Yönetimi (statik sayfalar, blog, banner/slider, ana sayfa blokları)
6. İletişim & Teklif (lead listesi, durum takibi, CSV export, e-posta bildirim)
7. SEO (meta, slug, 301 yönetimi, sitemap, OG)
8. Genel Ayarlar (logo, iletişim, sosyal, çalışma saatleri, tema)
9. Pazarlama & Takip (Meta Pixel + CAPI, GA4, GTM, Google Ads, event mapping, özel kod enjeksiyon)
10. Öncesi/Sonrası galeri yönetimi
11. Müşteri Yorumları yönetimi
12. SSS (kategori bazlı, sayfa-bazlı görünürlük, otomatik FAQPage schema)
13. Kullanıcı & Rol Yönetimi (yalnızca Admin)

---

## 12. TEKNİK GEREKSİNİMLER (Claude Code için)

- **Teknoloji:** Laravel + özel yönetim paneli (WordPress değil — performans ve özelleştirme için). Paylaşımlı hosting (cPanel/Turhost) → **`04-LARAVEL-CPANEL-DEPLOY-ANAYASASI.md` kurallarına %100 uyulacak.**
- **Mobil öncelikli, tam responsive** (mobil/tablet/masaüstü).
- **Performans:** görsel lazy-load + otomatik sıkıştırma/WebP; Lighthouse 90+; Core Web Vitals yeşil.
- **Erişilebilirlik:** semantik HTML, alt metinleri, klavye navigasyonu, kontrast.
- **Form güvenliği:** honeypot/reCAPTCHA, sunucu tarafı doğrulama, KVKK onayı.
- **Görsel galeri:** lightbox + thumbnail + swipe (mobil) + öncesi/sonrası karşılaştırma.
- **Sticky header + floating WhatsApp** her sayfada.
- **SEO landing sayfaları şablon bazlı:** panelden yeni "şehir+ürün" sayfası açılınca otomatik meta + URL üretilmeli.
- **Çoklu dil:** ŞU AN KAPSAM DIŞI — altyapı ileride EN eklenebilecek şekilde i18n'e uygun kurulsun (gelecek upsell). Aktif dil yalnızca TR; UI'da dil seçici **olmayacak** (sahte dil linki yok).

---

## 13. VERİ MODELİ (üst düzey — Claude Code için)

> Bu şema **minimum**dur. `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md` içindeki tüm özellikleri karşılayacak şekilde genişletilir; eksik alan/tablo bırakılmaz.

```
Urun         : id, ad, slug, aciklama, teknik_ozellikler(json: ebat, kalinlik,
               m2_adet, palet, renkler[], kullanim_alani[], dayanim, don_direnci),
               gorseller[] (çoklu), video_url, sira, durum(yayin/taslak),
               seo(meta_title, meta_desc, og_image)
Kategori     : id, ad, slug, gorsel, aciklama_seo, sira
UrunKategori : urun_id, kategori_id   (many-to-many pivot)
Proje        : id, baslik, slug, tip(konut/kamu/ticari/peyzaj), konum, tarih,
               aciklama, gorseller[], video_url, kullanilan_urunler[],
               musteri_adi, musteri_yorumu
OncesiSonrasi: id, baslik, oncesi_gorsel, sonrasi_gorsel, proje_id(nullable), sira
Hizmet       : id, ad, ikon, aciklama, gorsel, sira, seo
SeoLanding   : id, baslik(H1), slug, sehir, urun_tipi, icerik(uzun), gorseller[],
               meta_title, meta_desc, durum
Talep(Lead)  : id, ad, telefon, email, il_ilce, ilgi_alani, urun_id(nullable),
               m2, mesaj, foto(nullable), kvkk_onay, durum(yeni/okundu/arandi/
               sonuclandi), kaynak, olusturma_tarihi
Yorum        : id, ad, icerik, puan(nullable), gorsel(nullable), durum, sira
Sss          : id, soru, cevap, sira, durum, kategori
SssSayfa     : sss_id, sayfa_anahtar   (sayfa-bazlı görünürlük; boşsa tüm sayfalar)
Sayfa        : id, anahtar(home/about/...), bloklar(json), seo
Banner       : id, gorsel, baslik, link, sira, durum
BlogYazi     : id, baslik, slug, icerik, kapak, etiketler[], seo, durum   (faz 2)
Ayarlar      : telefon, whatsapp, email, adres, calisma_saatleri, sosyal{},
               logo, favicon, tema_renk
Pazarlama    : meta_pixel_id, capi_token(şifreli), capi_test_code, ga4_id,
               gtm_id, google_ads_id, ads_label, search_console_meta,
               head_kod, body_kod, event_mapping(json)
Yonlendirme  : id, eski_url, yeni_url, tip(301)
Kullanici    : id, ad, email, rol(admin/editor), sifre_hash
```

---

## 14. SEO & GEÇİŞ (MİGRASYON) PLANI

- **301 yönlendirme haritası:** sekmenyapi.com'daki tüm eski URL'ler → yeni karşılıklarına (Google değeri korunsun). Panelden yönetilebilir.
- Her sayfa için özgün **meta başlık + açıklama** (panelden düzenlenebilir).
- Ürün ve proje sayfaları için temiz, anahtar kelime içeren, Türkçe karaktersiz slug (örn. `/urunler/kilitli-parke-tasi`).
- **Yapısal veri (schema.org):** LocalBusiness, Product, BreadcrumbList, **FAQPage** (yalnızca sayfada render edilen SSS'ler — Google'ın "görünmeyen içerik schema'ya konmaz" kuralı).
- XML sitemap (otomatik) + robots.txt + Google Search Console.
- Görsellerde açıklayıcı dosya adı + alt metin (ürün/şehir bazlı: "konya-kilit-tasi-uygulamasi").
- Google Business Profile bağlantısı + NAP tutarlılığı (footer'daki ad/adres/telefon her yerde aynı).
- Pazarlama: GA4 + Meta Pixel + CAPI + GTM + Google Ads (panelden — bkz. admin §8).

---

## 15. İÇERİK ENVANTERİ (eski siteden taşınacak)

**Ürün modelleri (eski sitede 20+, güncel katalog 28):** 20x20, Ani, Assos, Antara Kolormix, Antik, Sardes, Begonit, Garden 1 Beyaz/Siyah Yıkama, İkonya 30x30, Klasik Kilitli, Mihenk, Misya, Naturalis, Papyon, Patara Altıgen, Truva, Myra, Pando, Perge, Likya, Dikdörtgen Takoz → güncel 28 listeyle eşlenecek.
**Referans/uygulama görselleri:** 24+ saha fotoğrafı → yeni galeriye taşınacak, kategorize edilecek.
**Kurumsal metin:** Apartman, site, villa, fabrika, çiftlik evi, kamu mülkleri için altyapı, üstyapı ve peyzaj uygulamaları → yeniden yazılacak (SEO + marka tonu).
**İletişim (doğrulanacak):** GSM 0533 607 89 76 · Telefaks 0332 342 24 76 · bilgisekmenyapi@hotmail.com · Yazır Mh. Canfeda Sk. No:16/A Selçuklu/Konya + Google Maps.
**Öneri:** Yeni kurumsal e-posta → info@sekmenzemintasarim.com.

---

## 16. ÇALIŞMA AKIŞI (BU PROJE İÇİN)

1. **Bu masterprompt + `01` özellik dosyası → Google Stitch:** §4–9 verilerek UI/arayüz tasarımı üretilir (sayfa sayfa).
2. **Stitch çıktısı gözden geçirilir**, marka yönüne (`03` rehber) göre rafine edilir.
3. **Tasarım + `01`/`02`/`04` → Claude Code:** ön yüz kodlanır, **veritabanı `01`'deki tüm özelliklere göre kurulur**, yönetim paneli ve formlar bağlanır, SEO/301 kurulur, deploy anayasasına uyulur.
4. **İçerik girişi:** ürünler, projeler, kurumsal metinler panelden girilir.
5. **QA & test:** mobil, form, link, hız, KVKK, **her panel özelliğinin frontend yansıması** kontrol edilir (çalışmayan kısım kalmamalı).
6. **Yayın:** DNS/alan adı (deploy anayasası §9), 301 yönlendirmeler, Search Console & Analytics, canlıya alma.
7. **Yayın sonrası:** izleme, blog/içerik planı, ileride EN dil + çok dillilik upsell'i.

### Çalıştırma (Claude Code, otonom mod)
`cd C:\laragon\www\sekmenzemin && claude --dangerously-skip-permissions`
**Otonom yürütme:** Komut sonrası soru sorma, onay isteme; en mantıklı profesyonel varsayımı yap, kısa not düş, durmadan ilerle (kurulum → dosya yapısı → tüm sayfalar → içerik → responsive → stil/animasyon → test → hata düzeltme → yayına hazır son hal). Hataları kendin çöz. Sadece sonunda özet ver.

---

## 17. TİCARİ NOTLAR (iç — müşteriyle paylaşılmaz)

- Teklif iki paket: temel vitrin sitesi + tam yönetilebilir kurumsal site (premium, "Önerilen" rozetli, admin panelli). Hedef: premium pakete yönlendirme (gold renk + "Önerilen" badge ile psikolojik yönlendirme).
- **Çok dillilik bilinçli olarak kapsam dışı** — ileride upsell.
- Alan adı alternatifleri müşteriye sunuldu: sekmenzemintasarim.com / sekmen.tr.
- Marka/patent başvuru hizmeti hediye olarak konumlandırıldı.
- Bazı özellikler (gelişmiş analytics, blog içerik üretimi, ek dil) bilinçli olarak sonraki fazlara/upsell'e bırakıldı.

---

## 18. AÇIK SORULAR (özet checklist — Stitch'e vermeden kapat)

- [ ] Onaylı slogan / tek cümle tanım
- [ ] Logo durumu (var / tasarlanacak) + kurumsal renk teyidi
- [ ] Marka kapsamı: sadece parke taşı mı, epoksi/beton baskı/peyzaj da mı
- [ ] Üretim mi / uygulama-satış mı (ürün dili)
- [ ] Fiyat gösterilecek mi yoksa sadece teklif mi
- [ ] Ürün gruplama mantığı + Color Mix model mi varyant mı
- [ ] Ürün ebat-kalınlık bilgileri + güncel yüksek çözünürlüklü görseller
- [ ] Hizmet tam listesi
- [ ] Blog ve SSS ilk fazda mı
- [ ] sekmenyapi.com yayında mı kalacak / tamamen yönlendirilecek mi
- [ ] Rakam sunum biçimi (800.000+ / 1.000.000 m²)
- [ ] Belge/sertifika var mı; güncel e-posta, adres, sosyal medya

---

*Bu masterprompt yaşayan bir dokümandır. Müşteri cevapları ve kararlar geldikçe ilgili bölümler güncellenir; Stitch ve Claude Code'a son haliyle aktarılır.*
