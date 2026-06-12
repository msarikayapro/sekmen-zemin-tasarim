# 01 — SEKMEN ZEMİN TASARIM: SİTE & PANEL ÖZELLİKLERİ (KURULUM ANAYASASI)

> **⚠️ CLAUDE CODE: BU DOSYAYI EN BAŞTA, KOD YAZMADAN ÖNCE BAŞTAN SONA OKU.**
>
> Bu dosya, sitenin ve admin panelin **kesinleşmiş, eksiksiz özellik listesidir.** Veritabanı şeması, backend (model/controller/route/policy/migration) ve frontend (sayfa/bileşen/form/panel ekranı) **buradaki her özelliği eksiksiz karşılayacak şekilde** kurulur.
>
> **Altın kural:** Her özellik **üç katmanda birden** tamamlanır → (1) Veritabanı tablosu/alanı, (2) Backend CRUD + iş mantığı, (3) Frontend yansıması (sitede görünen yer + panelde yönetim ekranı). Üçünden biri eksikse özellik **bitmemiş** sayılır. **Sonradan çalışmayan hiçbir kısım kalmayacak.**

**Stack:** Laravel + özel admin panel · Paylaşımlı hosting (cPanel/Turhost) · Deploy kuralları → `04-LARAVEL-CPANEL-DEPLOY-ANAYASASI.md`

---

## 0. KURULUM SIRASI (Claude Code uygula)

1. Bu dosyayı oku → tüm tablo/alan/ilişki ve panel modüllerini çıkar.
2. **Deploy anayasasını** uygula: `.env` (CACHE_STORE=file, SESSION_DRIVER=file başta), kök `.htaccess`, `SystemController` + web tabanlı cache temizleme, super-admin gate.
3. **Migration'ları** §2 veri modeline göre yaz (tüm tablolar, pivotlar, indexler, foreign key'ler).
4. **Model + ilişkiler** (many-to-many, eager loading, SoftDeletes gereken yerlerde).
5. **Admin panel** modüllerini kur (§3) — her modül CRUD + yetki (policy/gate).
6. **Frontend** sayfalarını kur (§4) — her biri gerçek veriden beslenir.
7. **Entegrasyonlar** (§5): form→lead+mail, WhatsApp, harita, pazarlama/tracking, SEO/schema, 301.
8. Test: her panel aksiyonunun frontend karşılığını doğrula. Çalışmayan = düzelt.

---

## 1. SİTE GENELİ — ZORUNLU ÖZELLİKLER (frontend)

Aşağıdakiler **her sayfada veya site genelinde** çalışır olacak:

- **Mobil öncelikli, tam responsive** (mobil/tablet/masaüstü).
- **Sticky header** (kaydırınca küçülerek sabit) + tıklanabilir telefon + "Teklif Al" butonu.
- **Floating/sticky WhatsApp butonu** (sağ alt, ön-doldurulmuş mesaj; ürün sayfasında ürün adı dahil).
- Tüm telefonlar `tel:` linkli (mobilde tıkla-ara), e-postalar `mailto:` linkli.
- **Lightbox + thumbnail + mobil swipe** galeriler.
- **Öncesi/Sonrası** karşılaştırma bileşeni (slider).
- **Scroll-reveal** ve hover animasyonları (rehber `03`'e göre, `prefers-reduced-motion` destekli).
- **Sayaç animasyonu** (rakamlarla biz).
- **Lazy-load + WebP** görseller, Lighthouse 90+ hedefi.
- Footer: sayfa linkleri, ürün kategorileri, iletişim, sosyal medya, KVKK + Çerez linkleri.
- KVKK Aydınlatma Metni + Çerez Politikası sayfaları.
- **Çok dil YOK** (UI'da dil seçici olmayacak) ama kod i18n'e uygun bırakılacak (gelecek upsell).

---

## 2. VERİTABANI — TAM ŞEMA (eksiksiz kur)

> Bu şema kesindir. Her tablo + alan + ilişki kurulur. JSON alanlar yerine gerekiyorsa normalize tablo da açılabilir; karar Claude Code'a ait ama **hiçbir özellik veri katmanında eksik kalmayacak.**

### urunler
`id, ad, slug(unique), aciklama(text), ebat_en, ebat_boy, kalinlik, m2_adet, palet_bilgi, renk_secenekleri(json/text), kullanim_alanlari(json/text), dayanim, don_direnci, video_url(nullable), sira(int), durum(enum: yayin/taslak), meta_title, meta_desc, og_image, created_at, updated_at, deleted_at(SoftDeletes)`

### urun_gorselleri  (bir ürün → çok görsel)
`id, urun_id(FK), yol, alt_metin, sira`

### kategoriler
`id, ad, slug(unique), gorsel(nullable), aciklama_seo(text), sira, created_at, updated_at`

### urun_kategori  (many-to-many pivot — bir taş birden çok kategoride)
`urun_id(FK), kategori_id(FK)`  · PRIMARY KEY(urun_id, kategori_id)

### projeler
`id, baslik, slug(unique), tip(enum: konut/kamu/ticari/peyzaj), konum, tarih, aciklama(text), video_url(nullable), musteri_adi(nullable), musteri_yorumu(text,nullable), one_cikan(bool), sira, durum, created_at, updated_at`

### proje_gorselleri
`id, proje_id(FK), yol, alt_metin, sira`

### proje_urun  (proje ↔ kullanılan taş çeşitleri, many-to-many)
`proje_id(FK), urun_id(FK)`

### oncesi_sonrasi
`id, baslik, oncesi_gorsel, sonrasi_gorsel, proje_id(FK,nullable), sira, durum`

### hizmetler
`id, ad, slug, ikon, aciklama(text), gorsel, sira, durum, meta_title, meta_desc`

### seo_landing  (şehir+ürün şablon sayfaları)
`id, baslik_h1, slug(unique), sehir, urun_tipi, icerik(longtext), gorseller(json/ayrı tablo), meta_title, meta_desc, durum, created_at`

### talepler  (lead)
`id, ad, telefon, email(nullable), il_ilce(nullable), ilgi_alani(nullable), urun_id(FK,nullable), m2(nullable), mesaj(text,nullable), foto(nullable), kvkk_onay(bool), durum(enum: yeni/okundu/arandi/sonuclandi), kaynak(nullable), created_at`

### yorumlar  (müşteri yorumları)
`id, ad, icerik(text), puan(int,nullable), gorsel(nullable), one_cikan(bool), durum(enum: yayin/gizli), sira, created_at`

### sss
`id, soru, cevap(richtext), kategori, sira, durum, created_at`

### sss_sayfa  (sayfa-bazlı görünürlük; kayıt yoksa → tüm sayfalarda)
`sss_id(FK), sayfa_anahtar`  (ana_sayfa, urun_detay, projeler, hakkimizda, iletisim, kvkk, cerez...)

### sayfalar  (statik içerik / ana sayfa blokları)
`id, anahtar(unique: home/about/...), baslik, bloklar(json), meta_title, meta_desc, og_image`

### bannerlar  (slider / hero)
`id, gorsel, baslik(nullable), alt_metin, link(nullable), sira, durum`

### blog_yazilari  (faz 2 — yapı baştan kurulur)
`id, baslik, slug, icerik(longtext), kapak, etiketler(json), kategori, meta_title, meta_desc, durum, created_at`

### ayarlar  (key-value veya tek satır)
`telefon, whatsapp, email, adres, harita_embed, calisma_saatleri, logo, logo_koyu, favicon, tema_renk, sosyal_instagram, sosyal_facebook, sosyal_youtube, ...`

### pazarlama_ayarlari  (tracking merkezi)
`meta_pixel_id, meta_pixel_aktif(bool), capi_token(encrypted,nullable), capi_test_code, capi_aktif(bool), ga4_id, gtm_id, google_ads_id, google_ads_label, search_console_meta, head_kod(text), body_kod(text), event_mapping(json)`

### yonlendirmeler  (301)
`id, eski_url, yeni_url, tip(default 301), aktif(bool)`

### kullanicilar
`id, ad, email(unique), sifre_hash, rol(enum: admin/editor), created_at`

> **İndeks/performans:** slug alanlarına unique index; FK'lere index; `durum` ve `sira` sık sorgulanır → index. **Eager loading** zorunlu (N+1 yok). Listelerde **paginate()** (asla toplu get()).

---

## 3. ADMIN PANEL — MODÜL MODÜL ÖZELLİK LİSTESİ

> Detaylı UX/yetki açıklaması `02-SEKMEN-ADMIN-PANEL.md`'de. Burada **her modülün kodlanacak yetenekleri** kesin liste halinde. Hepsi gerçek CRUD + yetki kontrolü + frontend yansımasıyla kurulur.

**Panel prensibi:** Mobil-first, app hissi. Dashboard = aksiyon ekranı (büyük dokunmatik butonlar + bildirim rozetleri), grafik yığını değil. Alt sabit navigasyon barı. PWA (öneri: aktif). Dokunma alanı min. 44–48px. Yetkiye göre dinamik menü.

### M1. Dashboard
- Yeni teklif talebi sayacı/rozeti, hızlı aksiyon butonları ("Yeni Ürün", "Teklif Talepleri", "Proje Ekle", "Yorum Yönet", "Öncesi-Sonrası Ekle").
- İstatistik isteyen için ayrı "Raporlar" sekmesi (ana ekranı kalabalıklaştırmaz).

### M2. Ürün / Taş Kataloğu (28 çeşit)
- Ekle / düzenle / sil (SoftDelete).
- **Çoklu galeri görseli (sınırsız)** + alt metin + sıralama.
- **Video ekleme alanı** (URL).
- Teknik özellikler: ebat (en/boy), kalınlık, m²/palet, renk seçenekleri, kullanım alanları, dayanım, don direnci.
- **Çoklu kategori ataması** (many-to-many).
- **Sürükle-bırak sıralama.**
- Aktif/pasif (yayın/taslak).
- Ürün başına SEO alanları (meta title/desc, OG).

### M3. Kategori Yönetimi
- Ekle / düzenle / sil. Ad, slug, görsel/ikon, SEO açıklaması, sıralama. Many-to-many ürün ilişkisi.

### M4. Projeler / Referanslar
- Ekle/düzenle/sil. Proje adı, konum (şehir/ilçe), tip, tarih, çoklu foto galeri, video, **kullanılan taş çeşitleri (ürün kataloğuyla bağlantı)**, açıklama, müşteri adı/yorumu, öne çıkar.
- Filtre tipleri: konut/kamu/ticari/peyzaj.

### M5. İçerik Yönetimi
- **Statik sayfalar** (Hakkımızda, Üretim Süreci vb.) düzenleme.
- **Ana sayfa blokları** (hero, sayaçlar, öne çıkanlar) düzenleme.
- **Banner / slider** yönetimi (görsel, başlık, link, sıra).
- **Blog** (faz 2): yazı ekle/düzenle, kategori, SEO alanları.

### M6. İletişim & Teklif (Lead)
- Gelen form mesajları/teklif talepleri listelenir + **durum** (yeni/okundu/arandı/sonuçlandı).
- **Ürün-bazlı teklif** talepleri (otomatik ürün adıyla gelen).
- **Excel/CSV dışa aktarma.**
- Yeni talepte **e-posta bildirimi**.
- İletişim sayfası bileşenleri yönetimi: WhatsApp numarası, telefon, harita, çalışma saatleri.

### M7. SEO
- Her sayfa/ürün/landing için meta title + description + OG.
- URL (slug) düzenleme.
- **301 yönlendirme yönetimi** (eski sekmenyapi.com → yeni).
- **Sitemap.xml otomatik üretim** + Search Console.
- **SEO landing** ekle/düzenle (şehir+ürün; otomatik meta + URL).

### M8. Genel Ayarlar
- Logo (açık/koyu) / favicon / site başlığı.
- Sosyal medya linkleri.
- İletişim bilgileri, adres, harita embed, çalışma saatleri.
- Tema/renk ayarı.
- Çoklu kullanıcı + yetki seviyeleri (Admin'e ait).

### M9. Pazarlama & Takip (Tracking)
> Hepsi panelden girilir, frontend'e doğru inject edilir. Çalışan entegrasyon — placeholder değil.
- **Meta Pixel:** Pixel ID + "aktif (frontend inject)" toggle.
- **Conversions API (CAPI):** Access Token (şifreli; boşsa mevcut korunur), Test Event Code, "CAPI aktif (server-side)" toggle, **Test Event Gönder** butonu.
- **Event Mapping:** her site aksiyonu → Meta event + aktif/pasif. (whatsapp_click→Lead, phone_click→Contact, email_click→Contact, lead_form_submit→Lead, campaign_click→InitiateCheckout, urun_view→ViewContent, gallery_view→ViewContent, scroll_depth→CustomEvent **pasif**, time_on_page→CustomEvent **pasif**, page_view→PageView). Engagement event'leri quota için varsayılan pasif.
- **GTM** Container ID (kuruluysa GA4 buradan).
- **GA4** Measurement ID.
- **Google Ads** Conversion ID + Label.
- **Search Console** verification meta content.
- **Özel kod enjeksiyon:** `<head>` ve `<body>` için ayrı kod alanları + kaydet.

### M10. Öncesi/Sonrası Galeri
- Ekle/düzenle/sil: öncesi görsel + sonrası görsel + başlık + (opsiyonel) proje bağı + sıralama. Frontend'de slider bileşeni.

### M11. Müşteri Yorumları
- Ekle/düzenle/sil/gizle. Ad, içerik, puan, görsel, öne çıkar, sıralama, durum.

### M12. SSS (Soru & Cevap)
- Soru (zorunlu) + cevap (zengin metin) + sıra + aktif/pasif.
- **Kategori bazlı gruplama** (Genel, Kilitli Taş, Bordür, Döşeme, Peyzaj, Garanti/Bakım, Nakliye) — panelde sayaçlı liste.
- **Sayfa-bazlı görünürlük (kilit özellik):** "Görüneceği sayfalar" çoklu seçim. Boş → tüm sayfalar; seçili → sadece o sayfalar.
- **FAQPage schema (JSON-LD) OTOMATİK:** sayfada gerçekten render edilen aktif SSS'ler → o sayfaya `schema.org/FAQPage` JSON-LD inject. Görünmeyen SSS schema'ya dahil edilmez (Google penaltısından kaçınılır). Google Rich Results Test'ten geçmeli.

### M13. Kullanıcı & Rol Yönetimi (yalnızca Admin)
- Kullanıcı ekle/çıkar, rol ata (Admin / Editör).
- **Editör:** içerik ekle/düzenle (ürün, proje, öncesi-sonrası, yorum); kullanıcı yönetimi + kritik ayarlar yok; silme sınırlı. Editör "Kullanıcı Yönetimi" butonunu **hiç görmez** (dinamik dashboard).
- İleride 3. rol (Satış — sadece teklifler) eklenebilir, şimdilik iki rol.

### M14. Sistem / Bakım (deploy anayasası gereği)
- Super-admin'e kısıtlı `SystemController`: web'den migration (`migrate --force`), cache temizleme (`optimize:clear` + `view:clear`). Tahmin edilemez secret route + gate. Panelde tetik butonları.

---

## 4. FRONTEND SAYFALARI — VERİYE BAĞLANMA HARİTASI

> Her sayfa **gerçek DB verisinden** beslenir; statik/placeholder bırakılmaz.

| Sayfa | Beslenen veri | Aksiyon |
|---|---|---|
| Ana Sayfa | bannerlar, urunler(öne çıkan), hizmetler, projeler(öne çıkan), oncesi_sonrasi, yorumlar, ayarlar, sayaçlar | Teklif/WhatsApp |
| Ürünler | urunler + kategoriler (filtre) | Detaya git |
| Ürün Detay | urun + urun_gorselleri + urun_kategori + ilgili ürünler + sayfaya atanmış sss | "Bu ürün için teklif al" → form ürün adıyla |
| Hizmetler | hizmetler | Teklif |
| Projeler | projeler + filtre(tip) + proje_gorselleri + oncesi_sonrasi | Lightbox / detay |
| SEO Landing | seo_landing | Teklif/telefon (sabit blok) |
| Hakkımızda | sayfa(about) + ayarlar(rakamlar) | Güven |
| İletişim | ayarlar + harita + form | Lead |
| Blog (faz2) | blog_yazilari | Organik |
| Galeri/Katalog | proje_gorselleri / katalog PDF | İndir (mini form lead) |

**Form akışı (kritik):** Teklif formu → `talepler` tablosuna kayıt + e-posta bildirim + (event_mapping aktifse) Meta event + teşekkür ekranı. Ürün detaydan gelirse `urun_id` + ilgi_alanı otomatik dolu.

---

## 5. ENTEGRASYONLAR — ÇALIŞIR KURULACAK

- **Teklif formu → lead + e-posta:** sunucu doğrulama, honeypot/reCAPTCHA, KVKK zorunlu, `try-catch` mail.
- **WhatsApp:** sticky buton + ürün adı ön-dolu mesaj.
- **Google Maps:** iletişim + footer embed (panelden).
- **Pazarlama/Tracking:** §M9 — Pixel/CAPI/GA4/GTM/Ads panelden inject, event mapping çalışır.
- **SEO/Schema:** LocalBusiness + Product + BreadcrumbList + FAQPage (otomatik, sadece render edilen SSS).
- **301:** `yonlendirmeler` tablosundan middleware ile uygulanır.
- **Sitemap.xml + robots.txt** otomatik.

---

## 6. KABUL KRİTERLERİ (bitti sayılması için)

Bir özellik ancak şu üçü tamamsa "bitti":
1. ✅ **Veri katmanı:** tablo/alan/ilişki var, migration çalışıyor.
2. ✅ **Backend:** CRUD + iş mantığı + yetki (policy/gate) + doğrulama çalışıyor.
3. ✅ **Frontend:** panel ekranı + sitedeki yansıması gerçek veriden render ediliyor, butonlar gerçekten çalışıyor.

**Yayın öncesi checklist:**
- [ ] Tüm panel modülleri (M1–M14) CRUD çalışıyor, yetkiler doğru.
- [ ] Her ürün/proje/öncesi-sonrası/yorum/SSS sitede görünüyor.
- [ ] Teklif formu lead'e düşüyor + mail gidiyor + ürün adı taşınıyor.
- [ ] WhatsApp/telefon/harita çalışıyor.
- [ ] Pixel/CAPI/GA4/GTM/Ads inject doğru; Test Event geçiyor.
- [ ] FAQPage schema sadece görünen SSS'lerle Rich Results Test'ten geçiyor.
- [ ] 301'ler çalışıyor, sitemap üretiliyor.
- [ ] Mobil responsive + Lighthouse 90+.
- [ ] Deploy anayasasının tüm maddeleri (`04`) uygulandı; cache temizleme web'den çalışıyor.
- [ ] **Hiçbir buton/ekran/form ölü değil.** Çalışmayan kısım yok.

---

*Bu dosya kodlamanın anayasasıdır. Bir özellik burada varsa, üç katmanda birden eksiksiz kurulur.*
