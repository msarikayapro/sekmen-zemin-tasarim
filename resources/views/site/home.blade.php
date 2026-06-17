@extends('layouts.site')

@section('title', $sayfa?->meta_title ?: ayar('site_basligi') . ' | Konya Parke Taşı Uygulama')
@section('meta_desc', $sayfa?->meta_desc ?: ayar('slogan'))

@section('content')
    {{-- 1. HERO --}}
    <section class="relative w-full overflow-hidden">
        {{-- Arka plan ambiyansı (kaldırım motifi + gradyan) --}}
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-gradient-to-br from-surface-container to-surface-container-lowest pavement-pattern"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-background via-background/85 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-gutter items-center py-16 md:py-20 lg:min-h-[88vh]">
            {{-- Metin --}}
            <div class="max-w-2xl space-y-6">
                <span class="inline-block text-gold-light font-label-caps text-label-caps tracking-widest uppercase">Sekmen Zemin Tasarım · Konya</span>
                <h1 class="font-headline-xl text-4xl md:text-headline-xl text-cream-white leading-tight">
                    {!! str_replace('parke taşı', '<span class="text-gold-light">parke taşı</span>', e($banner->baslik ?? ayar('slogan'))) !!}
                </h1>
                <p class="text-body-lg font-body-lg text-stone-grey">{{ $banner->alt_baslik ?? 'Estetik, Dayanıklılık ve Zanaatın Buluştuğu Nokta. Sekmen Zemin Tasarım ile her adımda kaliteyi hissedin.' }}</p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('iletisim') }}" class="bg-gold-light text-background px-8 py-4 rounded-lg font-label-caps text-label-caps font-bold hover:shadow-[0_0_20px_rgba(212,169,92,0.4)] transition-all uppercase">Teklif Al</a>
                    <a href="{{ route('urunler.index') }}" class="border border-gold-light text-cream-white px-8 py-4 rounded-lg font-label-caps text-label-caps font-bold hover:bg-gold-light/10 transition-all uppercase">Ürünleri İncele</a>
                </div>
            </div>

            {{-- Şık görsel alanı --}}
            <div class="relative w-full max-w-md mx-auto lg:mx-0 lg:justify-self-end">
                {{-- Dekoratif gold çerçeve (offset) --}}
                <div class="absolute -inset-3 md:-inset-4 border border-gold-light/25 rounded-3xl pointer-events-none"></div>
                {{-- Yumuşak gold ışıma --}}
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gold-light/10 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Asıl görsel --}}
                <div class="relative rounded-2xl overflow-hidden border border-gold-light/20 shadow-2xl shadow-black/50 aspect-[4/5]">
                    <img src="{{ gorsel($banner?->gorsel) }}" alt="{{ $banner?->alt_metin ?: ayar('site_basligi', 'Sekmen Zemin Tasarım') }}" class="w-full h-full object-cover" {{ $banner?->gorsel ? '' : 'loading=lazy' }}>
                    <div class="absolute inset-0 bg-gradient-to-t from-background/50 via-transparent to-transparent"></div>
                </div>

                {{-- Yüzen kuruluş rozeti --}}
                <div class="absolute -bottom-4 -left-4 bg-surface-container-high/90 backdrop-blur border border-gold-light/30 rounded-xl px-5 py-3 shadow-xl">
                    <p class="font-headline-lg text-2xl text-gold-light font-bold leading-none">{{ ayar('kurulus_yili', 2010) }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-stone-grey mt-1">Yılından Beri</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. RAKAMLARLA BİZ (sayaç animasyonu — panelden aktif/pasif) --}}
    @if(ayar('rakamlar_aktif', '1'))
    <section class="bg-surface-container-low border-y border-surface-variant/30 py-12">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-2">
                <div class="text-gold-light font-headline-lg text-3xl md:text-headline-lg font-bold tabular-nums" data-counter="{{ (int) ayar('kurulus_yili', 2010) }}">{{ ayar('kurulus_yili') }}</div>
                <div class="text-stone-grey font-label-caps text-[10px] tracking-[0.2em] uppercase">Kuruluş Yılı</div>
            </div>
            <div class="space-y-2">
                <div class="text-gold-light font-headline-lg text-3xl md:text-headline-lg font-bold tabular-nums" data-counter="{{ (int) ayar('uygulama_m2', 1000000) }}" data-suffix="+ m²">0</div>
                <div class="text-stone-grey font-label-caps text-[10px] tracking-[0.2em] uppercase">Uygulama Alanı</div>
            </div>
            <div class="space-y-2">
                <div class="text-gold-light font-headline-lg text-3xl md:text-headline-lg font-bold tabular-nums" data-counter="{{ (int) ayar('proje_sayisi', 800) }}" data-suffix="+">0</div>
                <div class="text-stone-grey font-label-caps text-[10px] tracking-[0.2em] uppercase">Tamamlanan Proje</div>
            </div>
            <div class="space-y-2">
                <div class="text-gold-light font-headline-lg text-3xl md:text-headline-lg font-bold tabular-nums" data-counter="{{ (int) ayar('mutlu_musteri', 1000) }}" data-suffix="+">0</div>
                <div class="text-stone-grey font-label-caps text-[10px] tracking-[0.2em] uppercase">Mutlu Müşteri</div>
            </div>
        </div>
    </section>
    @endif

    {{-- 3. VİTRİN (Showcase) galerisi --}}
    @if($showcases->isNotEmpty())
    <section class="py-16 md:py-20 bg-surface-container-low border-y border-surface-variant/30 overflow-hidden">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <x-bolum-baslik ust="Vitrin" baslik="Vitrinden Ötesi" aciklama="Sahadan en yeni uygulamalarımız — fotoğraf ve videolarla. Bir karta dokunun, galeride gezinin." />
            <div class="flex gap-4 md:gap-6 overflow-x-auto snap-x snap-mandatory pb-4 reveal [scrollbar-width:thin]">
                @foreach($showcases as $s)
                    <a href="{{ gorsel($s->media_path) }}"
                       class="glightbox group relative shrink-0 w-[68%] sm:w-56 md:w-60 lg:w-64 snap-start rounded-2xl overflow-hidden border border-surface-variant/50 aspect-[9/16] bg-surface-container-lowest"
                       data-gallery="vitrin"@if($s->isVideo()) data-type="video"@endif>
                        <img src="{{ gorsel($s->kapak) }}" loading="lazy"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Sekmen Zemin Tasarım vitrin">
                        <div class="absolute inset-0 bg-gradient-to-t from-background/70 via-transparent to-transparent"></div>
                        @if($s->isVideo())
                            <span class="absolute inset-0 flex items-center justify-center">
                                <span class="w-14 h-14 rounded-full bg-background/50 backdrop-blur border border-gold-light/40 flex items-center justify-center text-gold-light material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">play_arrow</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            window.addEventListener('load', function () {
                if (window.GLightbox) {
                    GLightbox({ selector: '.glightbox', loop: true, touchNavigation: true });
                }
            });
        </script>
    @endpush
    @endif

    {{-- 3. ÖNE ÇIKAN ÜRÜNLER --}}
    <section class="py-20 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <x-bolum-baslik ust="Koleksiyonlarımız" baslik="Öne Çıkan Ürünler" aciklama="28 farklı parke taşı modelimizden öne çıkanlar." />
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
            @foreach($oneCikanUrunler as $urun)
                <x-urun-kart :urun="$urun" />
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('urunler.index') }}" class="inline-flex items-center gap-2 text-gold-light font-label-caps uppercase hover:gap-3 transition-all">Tüm Ürünler <span class="material-symbols-outlined">arrow_forward</span></a>
        </div>
    </section>

    {{-- 4. HİZMETLER --}}
    <section class="py-20 md:py-24 bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <x-bolum-baslik ust="Ne Yapıyoruz?" baslik="Hizmetlerimiz" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
                @foreach($hizmetler as $hizmet)
                    <a href="{{ route('hizmetler.index') }}" class="block p-8 bg-surface border-l-4 border-gold-light space-y-4 hover:bg-surface-variant/20 transition-colors reveal">
                        <span class="material-symbols-outlined text-gold-light text-4xl">{{ $hizmet->ikon ?: 'construction' }}</span>
                        <h3 class="font-headline-md text-lg text-cream-white">{{ $hizmet->ad }}</h3>
                        <p class="text-stone-grey text-sm leading-relaxed line-clamp-3">{{ $hizmet->aciklama }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. NEDEN SEKMEN + SEO blok --}}
    <section class="py-20 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-10 reveal">
                <div class="space-y-4">
                    <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg text-cream-white">{{ $sayfa?->bloklar['neden_baslik'] ?? 'Neden Sekmen Zemin?' }}</h2>
                    <p class="text-stone-grey leading-relaxed">{{ $sayfa?->bloklar['neden_aciklama'] ?? "Konya'da kilit parke taşı uygulamalarında liderliği hedefleyen firmamız, her projeyi bir sanat eseri titizliğiyle ele alır." }}</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach([['verified','Üstün Kalite','En dayanıklı malzemeleri en doğru mühendislik teknikleriyle birleştiriyoruz.'],['engineering','Yılların Tecrübesi','2010\'dan beri en zorlu zeminlerde bile çözüm üretiyoruz.'],['workspace_premium','Garanti','İşçilik ve malzeme garantisi sunuyoruz.'],['schedule','Zamanında Teslim','Projeleri söz verdiğimiz tarihte eksiksiz teslim ediyoruz.']] as [$ikon,$b,$a])
                        <div class="flex gap-4">
                            <span class="material-symbols-outlined text-gold-light text-3xl shrink-0">{{ $ikon }}</span>
                            <div><h4 class="font-bold text-cream-white mb-1">{{ $b }}</h4><p class="text-xs text-stone-grey">{{ $a }}</p></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="relative bg-surface-container-high p-10 rounded-2xl border border-surface-variant/30 reveal">
                <div class="absolute -top-4 -right-4 bg-gold-light text-background px-4 py-2 rounded-lg font-bold text-sm">SEO Bilgi</div>
                <h3 class="text-headline-md font-headline-md text-cream-white mb-6">{{ $sayfa?->bloklar['seo_blok_baslik'] ?? 'Neden Kilitparke?' }}</h3>
                <div class="text-stone-grey text-sm space-y-4 leading-relaxed">
                    {!! $sayfa?->bloklar['seo_blok_icerik'] ?? '<p>Kilit parke taşı, dış mekanlar için en çok tercih edilen zemin kaplama yöntemidir.</p>' !!}
                </div>
            </div>
        </div>
    </section>

    {{-- 6. ÖNCESİ / SONRASI --}}
    @if($oncesiSonrasi)
    <section class="py-20 md:py-24 bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <x-bolum-baslik baslik="Değişimi Görün" aciklama="Uygulama öncesi ve sonrası arasındaki profesyonel farkı kaydırarak inceleyin." />
            <div class="max-w-4xl mx-auto reveal">
                <x-oncesi-sonrasi :kayit="$oncesiSonrasi" />
            </div>
        </div>
    </section>
    @endif

    {{-- 7. ÖNE ÇIKAN PROJELER --}}
    @if($projeler->isNotEmpty())
    <section class="py-20 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <x-bolum-baslik baslik="Proje Galerimiz" ust="Referanslar" />
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-gutter [&>*]:mb-gutter">
            @foreach($projeler as $proje)
                <a href="{{ route('projeler.show', $proje) }}" class="relative group block overflow-hidden rounded-xl break-inside-avoid reveal">
                    <img src="{{ gorsel($proje->kapak) }}" alt="{{ $proje->baslik }}" loading="lazy" class="w-full group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-background/90 to-transparent opacity-80 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end">
                        <h4 class="text-gold-light font-bold">{{ $proje->baslik }}</h4>
                        <p class="text-xs text-stone-grey">{{ $proje->konum }} @if($proje->tip) · {{ \App\Models\Proje::TIPLER[$proje->tip] ?? '' }}@endif</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 8. SÜREÇ --}}
    <section class="py-20 md:py-24 bg-surface-container-high/40 border-y border-surface-variant/30">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <x-bolum-baslik baslik="Nasıl Çalışıyoruz?" />
            <div class="relative">
                <div class="absolute top-8 left-0 w-full h-0.5 bg-surface-variant hidden md:block"></div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    @foreach([['1','Keşif','Ücretsiz yerinde ölçüm ve zemin analizi yapıyoruz.'],['2','Teklif','Bütçenize en uygun malzeme ve işçilik planını sunuyoruz.'],['3','Uygulama','Profesyonel ekiplerimizle titiz bir döşeme süreci yürütüyoruz.'],['4','Teslim','Temizlik ve son kontrollerin ardından işinizi teslim ediyoruz.']] as [$n,$b,$a])
                        <div class="relative z-10 bg-surface flex flex-col items-center text-center space-y-4 p-8 rounded-2xl border border-surface-variant/30 reveal">
                            <div class="w-16 h-16 rounded-full bg-gold-light text-background flex items-center justify-center font-bold text-xl">{{ $n }}</div>
                            <h4 class="font-bold text-cream-white">{{ $b }}</h4>
                            <p class="text-sm text-stone-grey">{{ $a }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 9. MÜŞTERİ YORUMLARI --}}
    @if($yorumlar->isNotEmpty())
    <section class="py-20 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <x-bolum-baslik baslik="Müşterilerimiz Ne Dedi?" ust="Sosyal Kanıt" />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            @foreach($yorumlar as $yorum)
                <div class="p-8 bg-surface-container-high rounded-2xl space-y-4 reveal">
                    <div class="text-gold-light flex gap-0.5">
                        @for($i=0;$i<($yorum->puan ?? 5);$i++)<span class="material-symbols-outlined fill text-lg">star</span>@endfor
                    </div>
                    <p class="text-stone-grey text-sm italic leading-relaxed">"{{ $yorum->icerik }}"</p>
                    <div><h5 class="font-bold text-cream-white">{{ $yorum->ad }}</h5>@if($yorum->unvan)<span class="text-[10px] text-stone-grey uppercase">{{ $yorum->unvan }}</span>@endif</div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 10. SSS (sayfaya atanmış) --}}
    <x-sss-bolum :ssler="$ssler" baslik="Sıkça Sorulan Sorular" />

    {{-- 11. CTA BANDI --}}
    <x-cta-bandi />
@endsection
