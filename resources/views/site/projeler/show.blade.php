@extends('layouts.site')

@section('title', $proje->baslik . ' | Sekmen Zemin Tasarım')
@section('meta_desc', \Illuminate\Support\Str::limit(strip_tags($proje->aciklama), 155))
@section('og_image', gorsel($proje->kapak))

@section('content')
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-16">
        <nav class="flex flex-wrap gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span>
            <a href="{{ route('projeler.index') }}" class="hover:text-gold-light">Projeler</a><span>/</span>
            <span class="text-on-surface">{{ $proje->baslik }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-[10px] uppercase tracking-widest text-gold-light">{{ \App\Models\Proje::TIPLER[$proje->tip] ?? '' }}</span>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight mt-1">{{ $proje->baslik }}</h1>
                <p class="text-stone-grey mt-2">{{ $proje->konum }} @if($proje->tarih)· {{ $proje->tarih }}@endif</p>
            </div>
            <a href="{{ route('iletisim') }}" class="bg-gold-light text-background px-6 py-3 rounded-lg font-label-caps text-xs font-bold uppercase hover:bg-gold-dark transition-colors self-start">Benzer Proje İçin Teklif Al</a>
        </div>

        {{-- Kapak --}}
        <div class="rounded-2xl overflow-hidden border border-surface-variant mb-8" data-lightbox-trigger data-full="{{ gorsel($proje->kapak) }}">
            <img src="{{ gorsel($proje->kapak) }}" alt="{{ $proje->baslik }}" class="w-full max-h-[520px] object-cover cursor-zoom-in">
        </div>

        @if($proje->aciklama)
            <div class="prose-invert max-w-3xl text-stone-grey leading-relaxed mb-10">{!! nl2br(e($proje->aciklama)) !!}</div>
        @endif

        {{-- Galeri --}}
        @if($proje->gorseller->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-12" data-gallery>
                @foreach($proje->gorseller as $g)
                    <button type="button" data-lightbox-trigger data-full="{{ gorsel($g->yol) }}" class="aspect-square rounded-xl overflow-hidden group">
                        <img src="{{ gorsel($g->yol) }}" alt="{{ $g->alt_metin ?: $proje->baslik }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform cursor-zoom-in">
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Öncesi / Sonrası --}}
        @if($proje->oncesiSonrasi->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter mb-12">
                @foreach($proje->oncesiSonrasi as $os)
                    @if($os->oncesi_gorsel && $os->sonrasi_gorsel)<x-oncesi-sonrasi :kayit="$os" />@endif
                @endforeach
            </div>
        @endif

        {{-- Kullanılan ürünler --}}
        @if($proje->urunler->isNotEmpty())
            <h2 class="font-headline-md text-xl text-cream-white mb-6">Kullanılan Taş Çeşitleri</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-gutter mb-8">
                @foreach($proje->urunler as $u)<x-urun-kart :urun="$u" />@endforeach
            </div>
        @endif

        @if($proje->musteri_yorumu)
            <div class="bg-surface-container-high rounded-2xl p-8 border-l-4 border-gold-light max-w-3xl">
                <span class="material-symbols-outlined text-gold-light text-3xl">format_quote</span>
                <p class="text-stone-grey italic mt-2">"{{ $proje->musteri_yorumu }}"</p>
                @if($proje->musteri_adi)<p class="text-cream-white font-bold mt-3">— {{ $proje->musteri_adi }}</p>@endif
            </div>
        @endif
    </section>

    {{-- Lightbox katmanı --}}
    <div data-lightbox class="hidden fixed inset-0 z-[300] bg-background/95 items-center justify-center p-4 cursor-zoom-out">
        <img src="" alt="Büyük görsel" class="max-w-full max-h-full rounded-lg">
    </div>

    <x-cta-bandi />
@endsection
