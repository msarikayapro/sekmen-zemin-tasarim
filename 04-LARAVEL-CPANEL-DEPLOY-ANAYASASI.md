# 04 — LARAVEL cPanel/TURHOST DEPLOY & GELİŞTİRME ANAYASASI

> **Sekmen Zemin Tasarım projesi (ve sonraki tüm paylaşımlı hosting projeleri) için bağlayıcı deploy kurallarıdır.** Ana bağlam → `00-SEKMEN-ANA-MASTERPROMPT.md` §12. Kurulum sırası → `01-SEKMEN-SITE-OZELLIKLERI-KURULUM.md` §0. Claude Code bu kurallara %100 sadık kalır.

---

# Laravel Paylaşımlı Hosting (cPanel / Turhost) — Deploy & Geliştirme Anayasası

> **Claude / Claude Code'a Masterprompt:** Aşağıdaki kurallar bu projenin (ve bundan sonraki tüm paylaşımlı hosting projelerinin) **anayasasıdır**. Bana vereceğin tüm yönergeleri, kodları ve adımları **yalnızca bu kurallara %100 sadık kalarak** üreteceksin. Önceki projelerimde yaşadığım veritabanı kilitlenmeleri, 405 hataları, redirect döngüleri, SSL Mixed Content ve cache kalıntısı sorunlarının **hiçbirini tekrar yaşamak istemiyorum.** Kuralları anladıysan "Sistem kurallarını kabul ettim" diyerek onayla ve ilk iş olarak `SystemController` + cache temizleme + DNS/domain kontrol akışını kurarak başla.

**Hedef ortam:** cPanel / Turhost paylaşımlı hosting · **SSH erişimi:** Yok (web tabanlı çözümler şart) · **Framework:** Laravel

---

## 0. Çalışma Felsefesi (Özet)

- Terminal erişimi yok varsay; her bakım işini (migration, cache temizliği) **web üzerinden** yapılabilir kur.
- Kullanıcıya/cliente dönük materyaller teknik değil; teknik karmaşıklık benim (geliştirici) tarafımda kalır.
- Continuous Delivery: doğrudan `main` üzerinde çalış, küçük ve sık pushla; `main`'e push = otomatik deploy (bkz. Bölüm 12).
- DB şifresinde `$ " \` karakterlerini asla kullanma (bkz. Bölüm 15) — deploy hatalarının çoğunu peşinen önler.

---

## 1. Geliştirme ve Git İş Akışı (Kesintisiz Teslimat)

1. **Asla** PR veya feature branch açma. Tüm geliştirme, düzeltme ve özellikler doğrudan yereldeki `main` (veya `master`) branch'inde yapılır.
2. İş bitince yaptığın güncellemeyi özetleyen **net bir commit mesajı** yaz ve doğrudan `origin main`'e pushla.
3. Sürekli "Continuous Delivery" mantığıyla çalış — büyük yığın değişiklik yerine küçük, izlenebilir adımlar.

---

## 2. Veritabanı ve Önbellek Güvenlik Ayarları (.env)

1. **Host:** `DB_HOST` değerini kesinlikle `127.0.0.1` yerine **`localhost`** yap. Paylaşımlı sunucular IP adresini reddedebilir.
2. **16 karakter sınırı:** cPanel kullanıcı adı/veritabanı adını 16 karakterde kırpabilir. `DB_USERNAME` ve `DB_DATABASE` alanlarını, cPanel "Mevcut Kullanıcılar/Veritabanları" listesinde **tam görünen (kırpılmışsa kırpılmış) hâliyle** yaz.
3. **Döngü engelleme (KRİTİK):** Proje ilk ayağa kalkarken veritabanı boş olur; Laravel session/cache için DB ararsa "Table not found / 500" döngüsüne girer. İlk kurulumda `.env` içinde **kesin olarak** şunları sabitle:
   - `CACHE_STORE=file`
   - `SESSION_DRIVER=file`
4. **Şifre güvenliği:** `DB_PASSWORD` özel karakter içeriyorsa değeri **tek tırnak** içine al: `DB_PASSWORD='p@ss!word'`.

---

## 3. Trafik ve Yönlendirme (.htaccess)

Kullanıcı URL'de `public` görmemeli, doğrudan ana domain üzerinden GET/POST iletilebilmeli ve **405 Method Not Allowed** ile redirect döngüleri oluşmamalı. Projenin **KÖK (root)** dizinine şu `.htaccess` kurulur:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # HTTP -> HTTPS Güvenli Yönlendirmesi
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Public Klasörü Trafik Akışı (405 ve yönlendirme döngülerini engeller)
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 4. Canlı Ortam ve SSL (Mixed Content) Güvenliği

1. Canlıya çıkarken `.env`:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://[yeni-domain].com`
2. **HTTPS şeması zorlaması** — iki seçenekten projeye uygun olanı:
   - **Tercih edilen (proxy arkasında):** `AppServiceProvider` yerine **`TrustProxies`** ayarında `protected $proxies = '*';` yapılandır. Load Balancer/SSL sonlandırma arkasında en doğru yöntem budur.
   - **Alternatif (basit ortam):** `app/Providers/AppServiceProvider.php` `boot()` içine:
     ```php
     use Illuminate\Support\Facades\URL;
     // ...
     if (config('app.env') === 'production') {
         URL::forceScheme('https');
     }
     ```
   > Aynı projede ikisini birden uygulama; çakışma yaratır. Proxy arkasındaysan `TrustProxies`'i seç.

---

## 5. Deploy & Otomasyon — Web Tabanlı Bakım (KRİTİK)

SSH olmadığından migration ve cache temizliğini web'den yapabilmeliyiz.

1. İlk iş olarak **yetki kontrollü** (sadece super-admin) bir `SystemController` ekle. İçinde:
   - `runUpdate()` → `Artisan::call('migrate', ['--force' => true])`
   - `clearCache()` → `Artisan::call('optimize:clear')` + `Artisan::call('view:clear')`
2. Rotalar **tahmin edilemez bir secret** ile korunur (örn. `/admin/system-update-{SECRET}`), erişim policy/gate ile super-admin'e kısıtlanır.
3. Her deploy ve `.env` değişikliği sonrasında `bootstrap/cache/` altındaki `config.php`, `routes-v7.php`, `services.php` gibi tüm önbellek dosyalarını **otomatik temizle** ("Access Denied" / "MissingAppKey" hatalarını önler).
4. Admin panelinde bu işlemleri tetikleyen butonlar bulunsun.

---

## 6. Blade, HTML ve 405 Koruması (KRİTİK)

1. **Kesinlikle iç içe (nested) form kullanma.** Geçmişte `@method('DELETE')` içeren gizli formların ana POST formuna sızması ölümcül **405** hatalarına yol açtı. Formlar daima birbirinden bağımsız.
2. Modal içi / tablo dışı input ve butonları ana forma bağlamak için **HTML5 `form="ilgili-form-id"`** attribute'unu kullan.

---

## 7. Proaktif Hata Önleme (Null-Safe & N+1)

1. `Attempt to read property on null` hatalarına karşı model ilişkilerini çağırırken **null-safe operatör** (`$item->user?->name`) veya `optional()` kullan.
2. `SoftDeletes` tablolarında ilişki çağrılarında `withTrashed()` eklemeyi unutma.
3. N+1 sorgu problemine karşı Controller'larda daima **eager loading** (`with('relation')`) kullan.
4. Büyük veride asla toplu `get()` yapma; **`paginate()`** kullan.

---

## 8. Güvenlik, Veri Bütünlüğü ve IDOR

1. ID ile işlem yapan tüm metodlarda (`/edit/{id}`, `/delete/{id}`) kaydın o kullanıcıya ait olup olmadığını veya kullanıcının admin olup olmadığını **Policy/Gate veya `where`** ile kontrol et. **IDOR** zafiyetine izin verme.
2. Finans, ödeme, rezervasyon gibi kritik kayıtlarda **Race Condition**'a karşı `DB::transaction` blokları kullan.
3. Dış servis çağrılarını (Mail, SMS vb.) daima **`try-catch`** içine al.

---

## 9. Domain, DNS ve CDN Çakışmaları

> Bu kurallar Hostinger deneyiminden gelir; cPanel/Turhost'ta da DNS/park sayfası mantığı benzer olduğundan koruyucu olarak uygulanır.

1. Alan adı yeni bağlanıyorsa, "park sayfası"na düşmemek için Nameserver değiştirmekle uğraşmak yerine **DNS Alan Editöründen `A` kayıtlarını doğrudan sunucu IP'sine** yönlendir (hem `@` hem `www`).
2. Bazı panellerde **CDN aktifken A kaydı eklenemez** hatası çıkar — A kayıtlarından önce CDN'i geçici kapat.
3. **Sürpriz silmeler:** Domain bağlama / Nameserver değişimi sırasında panel `public_html`'i sıfırlayabilir. Bu yüzden **önce DNS + domain bağlamayı bitir, dosyaları en son yükle.**

---

## 10. Dosya Yükleme Standardı (SSH yoksa)

1. Projeyi ziplerken **`vendor`, `node_modules`, `storage/logs`** klasörlerini **kesinlikle hariç tut**; boyut 10–20 MB'ı geçmesin.
2. File Manager arşiv çıkarırken klasör adı zorunlu tutabilir → önce **`gecici`** adlı klasöre çıkar, sonra ana dizine taşı.
3. `vendor` yüklenmediyse, dosyalar dizildikten sonra sunucuda (Claude Code / mümkünse SSH ile) `composer install --no-dev --optimize-autoloader` çalıştırılır. SSH yoksa, host'un sunduğu "Composer" arayüzü veya web tetikleyici alternatifi planlanır.

---

## 11. Son Kontrol — Cache Temizliği

Her şey bitince 404 / eski ayar patlamalarını önlemek için `SystemController` üzerinden (veya geçici `temizle.php` ile) tüm Laravel önbelleklerini sıfırla: `route:clear`, `config:clear`, `cache:clear`, `view:clear`.

---

## 12. GitHub Actions ile Otomatik Deploy (CI/CD — FTP)

> **FTP çelişkisi notu:** Hostinger kuralında "standart FTP yasak"tı; çünkü o hesaplar chroot ile `public_html`'e hapsedilir. cPanel/Turhost'ta ise **projeye özel, izole dizinli bir FTP hesabı** oluşturulup CI/CD için kullanılabilir. Yasak olan, çekirdek dosyaları güvenli bölgeye taşıyamayan hapsedilmiş FTP'ydi — burada izole hesap güvenlidir.

### 12.1 Sunucu Tarafı (cPanel)
1. **Projeye özel FTP hesabı** oluştur ve dizinini **yalnızca o projenin klasörüyle sınırla** (örn. `public_html/yeni-projem`). GitHub tüm sunucuya değil sadece o klasöre erişsin.
2. FTP sunucu adresi, kullanıcı adı ve şifreyi not et.

### 12.2 GitHub Secrets
Depo > **Settings > Secrets and variables > Actions** altında şu anahtarları ekle (şifreler asla koda yazılmaz):
- `FTP_SERVER`
- `FTP_USERNAME`
- `FTP_PASSWORD`

### 12.3 Workflow Dosyası
Proje köküne `.github/workflows/deploy.yml` oluştur:

```yaml
name: Deploy to cPanel via FTP

on:
  push:
    branches: [ main ]   # Sadece main'e push yapınca çalışır

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - name: Kodları Getir
        uses: actions/checkout@v4

      - name: Node.js Kur (Vite/Build için)
        uses: actions/setup-node@v4
        with:
          node-version: '20'

      - name: Paketleri Kur ve Build Et
        run: |
          npm install
          npm run build      # Vite/Tailwind kullanılıyorsa şart

      - name: FTP ile Sunucuya Gönder
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          protocol: ftps           # TLS desteği için MUTLAKA ftps
          timeout: 600000          # En az 10 dk
          server-dir: ./           # FTP hesabı zaten proje içinde
          exclude: |
            **/.git*
            **/node_modules/**
            **/vendor/**
            .env
            bootstrap/cache/*
            storage/*.key
```

### 12.4 Exclude Listesi — Kritik
Sunucudaki şu dosyalar deploy ile **silinmemeli/ezilmemeli**: `.env`, `bootstrap/cache/*`, `storage/*.key`, ayrıca `node_modules`, `vendor`, `.git`. (`vendor` GitHub runner'da `composer install` ile değil, sunucuda yönetilir; build çıktısı runner'da temiz üretilir.)

### 12.5 İlk Deploy ve Takip
1. `git add .` → `git commit -m "İlk otomatik deploy kurulumu"` → `git push origin main`.
2. **Actions** sekmesinden işlemi canlı izle.
3. Hata okuma: `Authentication Failed` → şifre yanlış · `Directory not found` → FTP yolu yanlış.
4. **Cloudflare** kullanılıyorsa her deploy sonrası **Purge Everything** yap, yoksa eski dosyalar görünür.
5. İlk yükleme uzun sürer (tüm dosyalar); sonrakiler sadece değişenleri attığı için saniyeler içinde biter.
6. **Lokaldeki `public/build` seni yanıltmasın** — runner kendi temiz build'ini üretip gönderir.

---

## 13. Sunucu Hazırlık Kontrol Listesi (İlk Kurulum)

1. **PHP sürümü:** cPanel'den PHP sürümünün Laravel gereksinimiyle (örn. 8.3) aynı olduğunu doğrula.
2. **Klasör izinleri:** `storage` ve `bootstrap/cache` klasörlerine yazma izni ver (**775**, gerekirse 777).
3. **Public path:** Kök dizine `.htaccess` ekleyip trafiği `public/`'e yönlendir (bkz. Bölüm 3).
4. **.env elle oluşturulur:** `.env` asla GitHub'a gitmez; sunucuda cPanel'den **bir kez elle** oluşturulur.

---

## 14. Veritabanı — cPanel Özel Detayları

1. **Prefix:** cPanel veritabanı ve kullanıcı isimlerinin başındaki `kullaniciadi_` ön ekini `.env`'e yazmayı unutma (Bölüm 2'deki 16 karakter kuralıyla birlikte düşün).
2. **Şifrede tek tırnak:** Özel karakterli şifreyi `.env`'de daima tek tırnakla yaz (Bölüm 2 ile aynı).
3. **Terminal yoksa import:** Yereldeki DB'yi dışa aktarırken `CREATE DATABASE` satırlarını sil, phpMyAdmin'e öyle yükle.
4. **Hayat kurtaran komut:** Site açılmaz / ayar yansımazsa (terminal varsa):
   ```bash
   php artisan config:clear && php artisan cache:clear && php artisan view:clear
   ```
   Terminal yoksa `bootstrap/cache` içindekileri elle sil veya Bölüm 5'teki `SystemController`'ı kullan.

---

## 15. 🚨 Kritik: Veritabanı Şifresi Karakter Kuralı

Deploy hatalarının büyük kısmı şifre karakterinden kaynaklanır. Şifre belirlerken:
- **Asla kullanma:** `$` (dolar), `"` (çift tırnak), `\` (ters bölü). Laravel bunları değişken/kaçış karakteri sanıp şifreyi bozar.
- **Güvenli alternatifler:** `@`, `-`, `_`, `.`, `!`.
- **Zorunlu tırnak:** Şifre ne olursa olsun `.env`'de daima tek tırnak: `DB_PASSWORD='yeni_sifren_2026!'`.

---

### Onay Cümlesi
Bu kuralları anladıysan **"Sistem kurallarını kabul ettim"** de ve ilk adım olarak `SystemController` + cache-temizleme mekanizmasını (rotalar + admin paneli butonu) kurarak başla.
