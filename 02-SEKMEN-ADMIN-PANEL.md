# 02 — SEKMEN ZEMİN TASARIM: ADMIN PANEL (DETAY)

> **Proje:** Sekmen Zemin Tasarım (eski: Sekmen Yapı) · **Domain:** www.sekmenzemintasarim.com
> **Hazırlayan:** Mustafa Sarıkaya — ReklamPro
> **İş akışı:** Planlama → Google Stitch (UI) → Claude Code (kod + yayın)
> **Amaç:** Parke/taş döşeme & peyzaj firması için tam yönetilebilir kurumsal site admin paneli.
>
> **Not:** Kodlanacak kesin özellik listesi ve veri şeması `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md`'dedir. Bu dosya panelin **UX felsefesi, modül davranışları ve yetki yapısını** açıklar. Ana bağlam → `00-SEKMEN-ANA-MASTERPROMPT.md` §11.

---

## TEMEL PRENSİP — "MOBİL UYGULAMA HİSSİ"

Panel masaüstünden değil, **çoğunlukla mobilden** yönetilecek. Bir "yönetim yazılımı" gibi değil, bir **mobil uygulama** gibi hissettirmeli.

### Tasarım kararları
- **Dashboard = aksiyon ekranı, rapor ekranı değil.** Açılışta grafik/istatistik yığını YOK. Yerine büyük, dokunması kolay hızlı erişim butonları: "Yeni Ürün Ekle", "Teklif Talepleri", "Proje/Referans Ekle", "Yorumları Yönet", "Öncesi-Sonrası Ekle".
- **Mobil-first layout:** dokunma alanları min. 44–48px, tek elle erişilebilir yerleşim, **altta sabit navigasyon barı** (app benzeri).
- **Kısayollar:** en sık işler bir-iki dokunuşla; derin menü hiyerarşisi yok.
- **Bildirim odağı:** "Yeni teklif talebi geldi" gibi durumlar dashboard'da **rozet/sayaç** ile öne çıkar (grafik yerine aksiyon-tetikleyici bilgi).
- **Sade görsel dil:** az ama net ikonlar, kart tabanlı yapı, app benzeri geçişler.
- **PWA opsiyonu:** telefon ana ekranına ikon olarak eklenebilir (öneri: evet).
- İstatistik/analitik isteyen olursa ayrı, ikincil **"Raporlar"** sekmesine — ana ekranı kalabalıklaştırmadan.

---

## ÇOK KULLANICILI / ROL YAPISI

Panel **çoklu kullanıcı + yetki seviyeli** olacak.

| Rol | Yetki |
|-----|-------|
| **Yönetici (Admin)** | Tam yetki: kullanıcı ekle/çıkar, tüm içerik, ayarlar, teklif talepleri, silme, pazarlama/tracking, SEO, sistem bakımı |
| **Editör / Personel** | İçerik ekle/düzenle (ürün, proje, öncesi-sonrası, yorum); kullanıcı yönetimi ve kritik ayarlara erişim yok, silme sınırlı |

- **Yetkiye göre dinamik dashboard:** editör "Kullanıcı Yönetimi" butonunu hiç görmez. (App hissi için şart.)
- İleride 3. rol (örn. yalnızca teklifleri gören "Satış") eklenebilir — şimdilik sade tutuluyor.
- Yetki kontrolü **Policy/Gate** ile; IDOR'a izin yok (her kayıtta sahiplik/rol kontrolü).

---

## MODÜLLER (DETAY)

### 1. Ürün / Taş Kataloğu
28 taş çeşidini yönetir. **Yetki:** Tam (ekle/düzenle/sil).

**Her taş için alanlar:**
- Ad, açıklama, slug.
- **Çoklu galeri görseli (sınırsız)** + alt metin + sıralama.
- **Video ekleme alanı** (ürün tanıtım/uygulama videosu — URL).
- Teknik özellikler: ebat (en/boy/kalınlık), m²/palet bilgisi, renk seçenekleri, kullanım alanları, dayanım, don direnci.
- **Kategori ataması (çoklu — many-to-many).**
- **Sürükle-bırak sıralama.**
- Aktif/pasif (yayın/taslak).
- SEO: meta title/desc, OG.

**Katalog (28):** Ani, Azure, Antara, Alinda, Antik, Assos, Ateş Çukuru, Baklava, Begonit, Bordür, Color Mix, İkonia, Kent Mobilyası, Kilitli, Likya, Limonluk, Merdiven, Misya 4cm, Myra, Naturalis, Papyon, Patara, Perge, Petek, Prizma, Truva, Yağmur Oluğu, Sardes.

### 2. Kategori Yönetimi
**Yetki:** Ekle/düzenle/sil. Alanlar: ad, görsel/ikon, açıklama (SEO metni), sıralama. Bir taş birden fazla kategoride olabilir (many-to-many).

### 3. Projeler / Referanslar
Tamamlanmış saha uygulamaları için ayrı modül. **Her proje için:** proje adı, konum (şehir/ilçe), tip (konut/kamu/ticari/peyzaj), çoklu foto galeri, video, **kullanılan taş çeşitleri (ürün kataloğuyla bağlantı)**, açıklama + tarih, müşteri adı/yorumu, öne çıkar.

### 4. İçerik Yönetimi
- **Statik sayfalar:** Hakkımızda, Üretim Süreci vb. düzenlenebilir.
- **Ana sayfa blokları:** hero, sayaçlar, öne çıkanlar.
- **Blog / Haber modülü:** SEO için içerik (faz 2 — yapı baştan kurulur).
- **Banner / slider yönetimi:** ana sayfa görselleri (görsel, başlık, link, sıra).
> SSS ayrı ve gelişmiş bir modül (bkz. Modül 9).

### 5. İletişim & Teklif
**Form yönetimi:**
- Gelen form mesajları/teklif talepleri panelde listelenir.
- **Ürün seçerek/ürün-bazlı** teklif talebi (otomatik ürün adıyla gelen).
- **Durum:** yeni / okundu / arandı / yanıtlandı / sonuçlandı.
- **Excel / CSV dışa aktarma.**
- Yeni talepte **e-posta bildirimi**.

**İletişim sayfası bileşenleri:** WhatsApp (tıkla-yaz), telefon + Google Maps, çalışma saatleri yönetimi.

### 6. SEO
- Her sayfa/ürün/landing için meta title + description + OG.
- URL (slug) düzenleme.
- **301 yönlendirme yönetimi** (eski sekmenyapi.com → yeni).
- **Sitemap.xml otomatik üretim** + Google Search Console.
- **SEO landing** ekle/düzenle (şehir+ürün, şablon bazlı, otomatik meta+URL).

### 7. Genel Ayarlar
Logo (açık/koyu) / site başlığı / favicon · sosyal medya linkleri · iletişim bilgileri, adres, harita embed, çalışma saatleri · Google Analytics kodu · çoklu kullanıcı + yetki · site geneli renk/tema.

### 8. Pazarlama & Takip (Tracking)
Meta reklam pixel bağlantısı ve tüm analitik entegrasyonların merkezi. **Hepsi panelden, frontend'e doğru inject — çalışır kurulum.**

**Meta Pixel:** Pixel ID + "Pixel aktif (frontend'e inject)" toggle.

**Conversions API (CAPI) — server-side:** Access Token (şifreli kayıt — boş bırakılırsa mevcut korunur), Test Event Code, "CAPI aktif" toggle, **Test Event Gönder** butonu.

**Event Mapping:** her site aksiyonu → Meta event + aktif/pasif toggle:

| Site Aksiyonu | Açıklama | Meta Event | Varsayılan |
|---|---|---|---|
| whatsapp_click | WhatsApp tıklandı | Lead | Aktif |
| phone_click | Telefon arama tıklandı | Contact | Aktif |
| email_click | E-posta tıklandı | Contact | Aktif |
| lead_form_submit | Teklif formu gönderildi | Lead | Aktif |
| campaign_click | Kampanya kartından geçiş | InitiateCheckout | Aktif |
| urun_view | Ürün detaydan "bilgi al" | ViewContent | Aktif |
| gallery_view | Galeri lightbox açıldı | ViewContent | Aktif |
| scroll_depth | Scroll derinliği (25/50/75/90%) | CustomEvent | **Pasif** |
| time_on_page | Sayfada süre (30/60/180s) | CustomEvent | **Pasif** |
| page_view | Sayfa görüntülendi | PageView | Aktif |

> Engagement event'leri (scroll_depth, time_on_page) çok sık fire eder; CAPI quota'sını korumak için varsayılan **pasif**.

**GTM:** Container ID (kuruluysa GA4 buradan; ayrı G- girmeye gerek yok).
**GA4:** Measurement ID (G-XXXXXXXXXX).
**Google Ads:** Conversion ID (AW-XXXXXXXXX) + Label.
**Search Console:** verification meta content değeri.
**Özel Kod Enjeksiyon:** `<head>` kod alanı (analitik script, doğrulama meta, preconnect) + `<body>` kod alanı (chat widget, GTM noscript, footer script) + Kaydet.

### 9. SSS (Soru & Cevap)
Kategorize edilebilen, sayfa-bazlı atanabilen, schema destekli gelişmiş modül.

**Giriş:** Soru (zorunlu) + Cevap (zorunlu, zengin metin) + Sıra (manuel) + Aktif/pasif.

**Kategori bazlı gruplama:** SSS'ler kategorilere ayrılır, panelde sayaçlı gruplu liste (örn. DEPO (2), ECZANE (3) gibi). Sekmen için: Genel, Kilitli Taş, Bordür, Döşeme, Peyzaj, Garanti/Bakım, Nakliye.

**Sayfa-bazlı görünürlük (kilit özellik):** "Görüneceği sayfalar" çoklu seçim. **Boş → tüm sayfalarda. Seçili → sadece o sayfalarda.** Örnek: Ana Sayfa, Ürün Kategori, Ürün Detay, Projeler, Hakkımızda, İletişim, KVKK, Çerez. (Ürün detayda "Bu taş ne kalınlıkta?", iletişimde "Nakliye yapıyor musunuz?" gibi bağlamsal sorular.)

**Liste görünümü:** kategori başlıkları altında gruplu (sayaçlı), her satırda düzenle/sil + hangi sayfada göründüğü etiketi.

**FAQPage Schema (JSON-LD) — ZORUNLU / OTOMATİK:**
- Bir sayfada görünen aktif SSS blokları → o sayfaya otomatik `schema.org/FAQPage` JSON-LD inject.
- Admin tarafında ekstra iş yok; soru/cevap girilince schema kendiliğinden üretilir.
- **Sadece sayfada gerçekten render edilen** SSS'ler dahil (sayfa-bazlı filtreden geçenler) — Google'ın "görünmeyen içerik schema'ya konmaz" kuralına uyum.
- Çıktı geçerli `Question + acceptedAnswer` yapısı; Google Rich Results Test'ten geçmeli.
- **Kazanım:** arama sonuçlarında açılır soru-cevap (rich result), tıklama artışı, organik görünürlük.

### 10. Öncesi/Sonrası Galeri
Ekle/düzenle/sil: öncesi + sonrası görsel + başlık + (opsiyonel) proje bağı + sıralama. Frontend'de karşılaştırma slider bileşeni.

### 11. Müşteri Yorumları
Ekle/düzenle/sil/gizle: ad, içerik, puan, görsel, öne çıkar, sıralama, durum.

### 12. Kullanıcı & Rol Yönetimi (yalnızca Admin)
Kullanıcı ekle/çıkar, rol ata. Editör kısıtlamaları yukarıda. Dinamik menü (editör admin-only modülleri görmez).

### 13. Sistem / Bakım
Deploy anayasası gereği super-admin'e kısıtlı `SystemController`: web'den migration + cache temizleme butonları (SSH yok). Bkz. `04` Bölüm 5.

---

## GELİŞTİRME NOTLARI
- **Multilingual:** şimdilik kapsam dışı, gelecek upsell (kod i18n'e uygun bırakılır).
- **SEO migration:** eski sekmenyapi.com linkleri için 301'ler kritik (Modül 6).
- **Marka kimliği:** koyu + gold modern (bkz. `03-SEKMEN-TASARIM-RENK-REHBERI.md`). Panel de aynı dilde, sade.
- Her modül **gerçek CRUD + frontend yansıması** ile bitirilir; çalışmayan ekran/buton bırakılmaz (kabul kriterleri → `01` §6).
