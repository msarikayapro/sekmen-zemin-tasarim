# 03 — SEKMEN ZEMİN TASARIM: RENK & ETKİLEŞİM REHBERİ

> Logodan türetilmiş tasarım sistemi: resmi palet, gradient reçeteleri, interaktif animasyon kütüphanesi.
> **Yön:** koyu temelli, **gold/altın vurgulu, modern lüks.** "Teknoloji, dizayn ve estetik" sloganıyla uyumlu.
> Ana bağlam → `00-SEKMEN-ANA-MASTERPROMPT.md` §4. Stitch'e renk/tipografi yönü için bu dosya verilir.

---

## 0. İKİ PALET — HANGİSİ ESAS?

Logodan iki ayrı pipetleme yapıldı. **Birincil palet** (kömür + gold + krem, aşağıda Bölüm 2) **esas alınır.** İkinci palet (antrasit `#13161A` tabanlı, açık altın `#C9962E`) **alternatif/yedek ton seti** olarak korunur; istenirse light bölümlerde veya ikinci tema olarak kullanılabilir. Claude Code tek bir CSS değişken setiyle başlar (birincil), ikinciyi yorum olarak ekler.

---

## 1. MARKA RENKLERİ (logodan pipetlendi)

Logo iki saf marka renginden oluşur:

| Renk | Hex | Açıklama |
|------|-----|----------|
| Kömür (Siyah) | `#0A0A0A` | Logo gövdesi, "SEKMEN" yazısı |
| Gold / Bronz | `#B6863E` | Logo aksanı, "ZEMİN TASARIM" yazısı, çizgiler |

Logo üç değer üzerine kurulu: **antrasit/siyah zemin**, **altın-bronz vurgu**, **kırık beyaz negatif alan**. "S" monogramı + zemin/kaldırım perspektif motifi markanın görsel imzası — lüks, kurumsal, sektöre (taş/zemin) uygun. Modern arayüz bu ikiliyi olduğu gibi kullanmaz; etrafına nötr ve doku tonları örerek nefes açar.

---

## 2. TAM RENK PALETİ (BİRİNCİL — ESAS)

| Rol | Hex | Kullanım |
|-----|-----|----------|
| **Gold (marka)** | `#B6863E` | Ana vurgu, butonlar, ikonlar, başlık vurgusu |
| Gold-açık | `#D4A95C` | Gradient üst ucu, hover parlaması |
| Gold-koyu | `#8C6526` | Gradient alt ucu, gölge, kenarlık |
| **Kömür (marka)** | `#0A0A0A` | Ana koyu zemin, başlık metni |
| Antrasit | `#161616` | Kart zemini, ikincil yüzey |
| Grafit | `#242424` | Kenarlık, ayraç, hover yüzeyi |
| Taş-gri | `#8A8A8A` | İkincil metin |
| Krem-beyaz | `#F5F2EC` | Koyu zemin üstü ana metin (saf beyaz değil — gold ile sıcak uyum) |
| Açık zemin | `#FBFAF7` | Light bölümler için kırık beyaz |

### Kontrast & Erişilebilirlik (WCAG)
- `#F5F2EC` metin × `#0A0A0A` zemin → **~19:1 (AAA)** ✓
- Gold `#B6863E` × koyu zemin → **~6.4:1 (AA)** — vurgu/başlık/buton için uygun, küçük gri metinde kullanma.
- **Gold zemin üstüne her zaman siyah metin** (`#0A0A0A`, ~6:1). Gold üstüne beyaz metin koyma.

### Alternatif palet (yedek — ikinci rehberden)
`--bg-darkest:#13161A · --bg-surface:#1E2228 · --bg-elevated:#2A2F38 · --gold:#C9962E · --gold-light:#E0B654 · --text:#F5F3EE · --text-muted:#8A8F98 · --border-soft:rgba(201,150,46,0.15) · --border-active:rgba(201,150,46,0.50)`

---

## 3. CSS DEĞİŞKENLERİ (birincil — kopyala-yapıştır)

```css
:root{
  /* Marka */
  --gold:#B6863E;
  --gold-lt:#D4A95C;
  --gold-dk:#8C6526;
  --ink:#0A0A0A;

  /* Yüzeyler */
  --surface:#161616;
  --line:#242424;
  --stone:#8A8A8A;
  --cream:#F5F2EC;
  --light:#FBFAF7;

  /* Hareket */
  --ease:cubic-bezier(.22,1,.36,1);
}
```

---

## 4. GRADIENT REÇETELERİ

```css
/* Gold buton & vurgu yüzeyi */
--grad-gold: linear-gradient(135deg, #D4A95C 0%, #B6863E 55%, #8C6526 100%);

/* Hero / koyu zemin derinliği */
--grad-dark: linear-gradient(160deg, #161616 0%, #0A0A0A 100%);

/* Kart üstü ince gold ışıma (radial, üst köşeden) */
--grad-glow: radial-gradient(120% 80% at 50% 0%, rgba(182,134,62,0.14) 0%, transparent 60%);

/* Başlık metni gold gradient (text-fill) */
--grad-text: linear-gradient(90deg, #D4A95C, #B6863E);

/* Ayraç çizgisi (logodaki gold çizgiler gibi) */
--grad-line: linear-gradient(90deg, transparent, #B6863E, transparent);
```

Başlık metnine gold gradient:
```css
.title-gold{
  background:var(--grad-text);
  -webkit-background-clip:text; background-clip:text;
  color:transparent;
}
```

> Gradient'ler **ölçülü** kullanılır — her yüzeye değil, sadece hero, CTA ve vurgulanmak istenen kartlara.

---

## 5. İNTERAKTİF ANIMASYON KÜTÜPHANESİ

Tümü GPU-dostu (`transform`/`opacity`). `prefers-reduced-motion` ile devre dışı. Ürün kartları (28 taş), butonlar, başlıklar için tasarlandı. Genel his: yumuşak, elegant, asla zıplayan/abartılı değil.

```css
/* 1) Ürün/taş kartı — kalkış + gold ışıma + kenarlık */
.card{
  background:var(--surface); border:1px solid var(--line);
  border-radius:16px; position:relative; overflow:hidden;
  transition:transform .5s var(--ease), box-shadow .5s var(--ease), border-color .5s var(--ease);
}
.card::after{
  content:""; position:absolute; inset:0;
  background:radial-gradient(120% 80% at 50% 0%, rgba(182,134,62,.18), transparent 60%);
  opacity:0; transition:opacity .5s var(--ease);
}
.card:hover{
  transform:translateY(-8px);
  border-color:rgba(182,134,62,.5);
  box-shadow:0 24px 48px -12px rgba(0,0,0,.6), 0 0 0 1px rgba(182,134,62,.2);
}
.card:hover::after{ opacity:1; }
.card img{ transition:transform .8s var(--ease); }
.card:hover img{ transform:scale(1.06); }

/* 2) Gold buton — gradient kayması + parlama sweep */
.btn{
  position:relative; overflow:hidden; color:var(--ink); font-weight:600;
  padding:14px 30px; border-radius:10px; border:0; cursor:pointer;
  background:linear-gradient(135deg,#D4A95C,#B6863E 55%,#8C6526);
  background-size:180% 180%; background-position:0% 50%;
  transition:background-position .6s var(--ease), transform .25s var(--ease), box-shadow .4s var(--ease);
}
.btn:hover{
  background-position:100% 50%;
  transform:translateY(-2px);
  box-shadow:0 12px 28px -8px rgba(182,134,62,.55);
}
.btn::before{
  content:""; position:absolute; top:0; left:-120%; width:60%; height:100%;
  background:linear-gradient(120deg,transparent,rgba(255,255,255,.35),transparent);
  transform:skewX(-20deg); transition:left .7s var(--ease);
}
.btn:hover::before{ left:140%; }

/* 3) Başlık altı gold ayraç — hover'da açılır */
.heading{ position:relative; color:var(--cream); }
.heading::after{
  content:""; position:absolute; left:0; bottom:-10px; height:2px; width:48px;
  background:linear-gradient(90deg,var(--gold),transparent);
  transition:width .5s var(--ease);
}
.heading:hover::after{ width:120px; }

/* 4) Link alt-çizgi reveal */
.link{ position:relative; color:var(--cream); text-decoration:none; }
.link::after{
  content:""; position:absolute; left:0; bottom:-3px; height:1px; width:100%;
  background:var(--gold); transform:scaleX(0); transform-origin:right;
  transition:transform .4s var(--ease);
}
.link:hover::after{ transform:scaleX(1); transform-origin:left; }

/* 5) Scroll-reveal (IntersectionObserver ile .in eklenir) */
.reveal{
  opacity:0; transform:translateY(24px);
  transition:opacity .7s var(--ease), transform .7s var(--ease);
}
.reveal.in{ opacity:1; transform:none; }

/* Öne çıkan kart — çizilen gold çerçeve (premium paket / öne çıkan ürün) */
.border-draw{ position:relative; }
.border-draw .bd-line{
  position:absolute; inset:0; border-radius:12px; padding:1px;
  background:linear-gradient(120deg,#B6863E,#D4A95C);
  -webkit-mask:linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
  -webkit-mask-composite:xor; mask-composite:exclude;
  opacity:0; transition:opacity .4s ease;
}
.border-draw:hover .bd-line{ opacity:1; }

/* Erişilebilirlik */
@media (prefers-reduced-motion:reduce){
  *{ transition:none !important; animation:none !important; }
}
```

### Scroll-reveal tetikleyici (JS)
```js
const io = new IntersectionObserver((es)=>es.forEach(e=>{
  if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
}),{threshold:.15});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
```

---

## 6. TİPOGRAFİ

- **Başlıklar:** güçlü, geniş harf aralıklı sans-serif (**Poppins** / Inter / Montserrat) — logodaki "SEKMEN" karakteri gibi `letter-spacing` ile ferahlık.
- **Gövde:** okunaklı, sade sans-serif.
- **Gold vurgu:** başlık vurgularında ve büyük rakamlarda (istatistik, "28 taş çeşidi", "1.000.000 m²") etkili.
- ReklamPro stil dili Poppins ile uyumlu.

---

## 7. MARKA MOTİFİ (Hero arka planı)
Logodaki zemin/kaldırım perspektif motifi (paralel çizgiler) hero arka planında ince, yavaş hareket eden çizgi animasyonu olarak yeniden kullanılabilir — marka ile birebir görsel bağ. Ek olarak yavaş hareket eden ince ışık/grain dokusu siteyi canlı tutar.

---

## 8. KULLANIM ÖZETİ

1. **İskelet:** koyu tema (`--ink`/`--surface`), bölüm geçişlerinde `--grad-dark` ile derinlik.
2. **Vurgu:** gold yalnızca dikkat çekilecek yerlerde (CTA, başlık vurgusu, ikon, ayraç) — fazla kullanım lüks hissini öldürür.
3. **Metin:** ana `--cream`, ikincil `--stone`.
4. **Ritim:** bazı bölümleri (ürün katalogu, referans galerisi gibi) açık zemine (`--light` + `--ink` metin + gold ayraç) ters çevirerek monotonluğu kır.
5. **Hareket:** her etkileşimde yumuşak `--ease`; kart kalkışı + görsel zoom, buton parlama sweep, başlıkta gold çizgi açılışı, scroll reveal.
6. **Marka bağı:** zemin perspektif motifini hero arka planında yeniden kullan.

> **ReklamPro stil referansı notu:** Önceki projelerde (Kaplamax) koyu yeşil glassmorphism + yeşil/altın aksan + Poppins kullanıldı. Sekmen için yön **koyu kömür + gold** (marka logosuna sadık); glassmorphism ve yumuşak animasyon dili korunur, ana vurgu rengi yeşil değil **gold**.
