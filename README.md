# Sekmen Zemin Tasarım

Konya merkezli parke/kilit taşı uygulama ve peyzaj firması için **Laravel 13** tabanlı, yönetim panelli (CMS) kurumsal web sitesi.

> Tasarım: koyu kömür + gold "Industrial Luxe" (Stitch). Stack: Laravel 13 · Tailwind v4 (Vite) · MySQL.

---

## Hızlı Başlangıç (Yerel / Laragon)

Proje zaten kuruludur. Çalıştırmak için:

```bash
# 1) MySQL çalışıyor olmalı (Laragon). Veritabanı: sekmen_zemin
# 2) Bağımlılıklar kuruluysa atlayın:
composer install
npm install

# 3) Frontend varlıklarını derleyin
npm run build          # veya geliştirme için: npm run dev

# 4) Sunucuyu başlatın
php artisan serve
```

Site: **http://127.0.0.1:8000**
Panel: **http://127.0.0.1:8000/panel/giris**

### Giriş Bilgileri (seed)

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Yönetici | `admin@sekmenzemintasarim.com` | `Sekmen2026!` |
| Editör | `editor@sekmenzemintasarim.com` | `Editor2026!` |

> İlk girişten sonra şifreleri panelden değiştirin.

### Veritabanını sıfırlamak / yeniden doldurmak

```bash
php artisan migrate:fresh --seed
```

Seed içeriği: 28 taş ürünü, 2 kategori, 6 hizmet, 6 proje, 6 yorum, 9 SSS, ayarlar, SEO landing'ler ve örnek 301 yönlendirmeler.

---

## Mimarî Özet

- **Veritabanı:** `database/migrations` (21 tablo). Ürün/kategori many-to-many, proje-ürün ilişkisi, SSS sayfa-bazlı görünürlük, lead, tracking, 301.
- **Modeller:** `app/Models` (Türkçe tablo adları, scope'lar, `gorsel()` fallback helper).
- **Frontend:** `resources/views/site` + `layouts/site` + `partials` + `components`.
- **Panel:** `resources/views/panel` + `layouts/panel` (mobil-first, alt navigasyon, rol bazlı menü).
- **Controller'lar:** Frontend `app/Http/Controllers`, panel `app/Http/Controllers/Panel`.
- **Yetki:** `panel.auth` (giriş) + `panel.admin` (yalnızca Admin: ayarlar, pazarlama, kullanıcı, sistem).
- **SEO:** otomatik sitemap.xml, LocalBusiness/Product/FAQPage schema, panelden meta + 301.
- **Tracking:** Meta Pixel + CAPI + GA4 + GTM + Google Ads, panelden inject, event mapping.

## Önemli Yollar

- `/sitemap.xml`, `/robots.txt`
- `/panel` — yönetim paneli
- Sistem bakımı (Anayasa §5): `/panel/sistem-{SYSTEM_SECRET}` (yalnızca Admin)

## cPanel / Turhost Deploy

`04-LARAVEL-CPANEL-DEPLOY-ANAYASASI.md` kurallarına uyulmuştur:

- Kök `.htaccess` trafiği `public/`'e yönlendirir (HTTP→HTTPS dahil).
- `.env.example` üretim şablonu (DB_HOST=localhost, file cache/session, şifre karakter kuralı).
- Web tabanlı bakım: `SystemController` (migrate + cache temizleme), tahmin edilemez secret route.
- `TrustProxies '*'` + production'da `URL::forceScheme('https')`.
- GitHub Actions FTP deploy: `.github/workflows/deploy.yml` (FTP_SERVER/USERNAME/PASSWORD secret'ları).

Deploy adımları:
1. Repoyu cPanel'e bağlı FTP ile gönderin (Actions otomatik) veya zip yükleyin (`vendor`, `node_modules` hariç).
2. Sunucuda `composer install --no-dev --optimize-autoloader`.
3. cPanel'den `.env` oluşturun (`.env.example`'dan), `php artisan key:generate`.
4. Panelden **Sistem > Migrate** ve **Önbelleği Temizle**.
5. `storage` ve `bootstrap/cache` yazma izinleri (775).
