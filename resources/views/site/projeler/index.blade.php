@extends('layouts.site')

@section('title', 'Projeler & Referanslar | Sekmen Zemin Tasarım')
@section('meta_desc', 'Tamamladığımız parke taşı ve peyzaj projeleri. Villa, kamu, ticari ve peyzaj uygulamalarından örnekler.')

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">Projeler</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight">Projeler & Referanslar</h1>
        <p class="text-stone-grey mt-3 max-w-2xl">Konut, kamu, ticari ve peyzaj alanlarında tamamladığımız uygulamalardan bir seçki.</p>

        <div class="flex flex-wrap gap-3 mt-8">
            <a href="{{ route('projeler.index') }}" class="px-5 py-2 rounded-full text-sm font-label-caps uppercase border transition-colors {{ ! $aktifTip ? 'bg-gold-light text-background border-gold-light' : 'border-surface-variant text-stone-grey hover:border-gold-light hover:text-gold-light' }}">Tümü</a>
            @foreach($tipler as $deger => $etiket)
                <a href="{{ route('projeler.index', ['tip' => $deger]) }}" class="px-5 py-2 rounded-full text-sm font-label-caps uppercase border transition-colors {{ $aktifTip === $deger ? 'bg-gold-light text-background border-gold-light' : 'border-surface-variant text-stone-grey hover:border-gold-light hover:text-gold-light' }}">{{ $etiket }}</a>
            @endforeach
        </div>
    </section>

    <section class="pb-16 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        @if($projeler->isEmpty())
            <p class="text-stone-grey text-center py-20">Bu kategoride henüz proje bulunmuyor.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                @foreach($projeler as $proje)
                    <a href="{{ route('projeler.show', $proje) }}" class="relative group block overflow-hidden rounded-xl aspect-[4/3] reveal">
                        <img src="{{ gorsel($proje->kapak) }}" alt="{{ $proje->baslik }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-background/95 via-background/30 to-transparent p-6 flex flex-col justify-end">
                            <span class="text-[10px] uppercase tracking-widest text-gold-light mb-1">{{ $tipler[$proje->tip] ?? '' }}</span>
                            <h4 class="text-cream-white font-bold">{{ $proje->baslik }}</h4>
                            <p class="text-xs text-stone-grey">{{ $proje->konum }} @if($proje->tarih)· {{ $proje->tarih }}@endif</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12">{{ $projeler->links() }}</div>
        @endif
    </section>

    {{-- Öncesi/Sonrası galeri --}}
    @if($oncesiSonrasi->isNotEmpty())
    <section class="py-16 bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <x-bolum-baslik baslik="Öncesi / Sonrası" aciklama="Dönüşümleri kaydırarak inceleyin." />
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter max-w-5xl mx-auto">
                @foreach($oncesiSonrasi as $os)
                    <div class="reveal"><x-oncesi-sonrasi :kayit="$os" /></div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <x-sss-bolum :ssler="$ssler" />
    <x-cta-bandi />
@endsection
