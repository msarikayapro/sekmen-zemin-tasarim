@extends('layouts.site')

@section('title', $sayfa?->meta_title ?: 'Hakkımızda | Sekmen Zemin Tasarım')
@section('meta_desc', $sayfa?->meta_desc ?: ayar('slogan'))

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">Hakkımızda</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight">{{ $sayfa?->baslik ?: 'Hakkımızda' }}</h1>
    </section>

    <section class="pb-16 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <div class="lg:col-span-2 space-y-5 text-stone-grey leading-relaxed prose-invert reveal">
            {!! $sayfa?->icerik ?: '<p>2010\'dan beri Konya merkezli olarak parke taşı uygulaması ve peyzaj alanında hizmet veriyoruz.</p>' !!}
        </div>
        <div class="space-y-4">
            <div class="bg-surface-container-high rounded-2xl p-6 border border-surface-variant/40">
                <h3 class="font-headline-md text-lg text-gold-light mb-4">Rakamlarla Biz</h3>
                <div class="space-y-4">
                    <div><p class="text-2xl font-bold text-cream-white">{{ ayar('kurulus_yili') }}</p><p class="text-xs text-stone-grey uppercase">Kuruluş</p></div>
                    <div><p class="text-2xl font-bold text-cream-white">{{ number_format((int)ayar('uygulama_m2'),0,',','.') }}+ m²</p><p class="text-xs text-stone-grey uppercase">Uygulama Alanı</p></div>
                    <div><p class="text-2xl font-bold text-cream-white">{{ ayar('proje_sayisi') }}+</p><p class="text-xs text-stone-grey uppercase">Tamamlanan Proje</p></div>
                </div>
            </div>
            @if($sayfa?->bloklar)
            <div class="bg-surface-container-high rounded-2xl p-6 border border-surface-variant/40 space-y-4">
                @if($m = ($sayfa->bloklar['misyon'] ?? null))<div><h4 class="text-gold-light font-bold text-sm uppercase mb-1">Misyon</h4><p class="text-stone-grey text-sm">{{ $m }}</p></div>@endif
                @if($v = ($sayfa->bloklar['vizyon'] ?? null))<div><h4 class="text-gold-light font-bold text-sm uppercase mb-1">Vizyon</h4><p class="text-stone-grey text-sm">{{ $v }}</p></div>@endif
            </div>
            @endif
            <div class="bg-surface-container-high rounded-2xl p-6 border border-surface-variant/40">
                <h4 class="text-gold-light font-bold text-sm uppercase mb-2">Hizmet Bölgelerimiz</h4>
                <p class="text-stone-grey text-sm">{{ ayar('hizmet_bolgeleri') }}</p>
            </div>
        </div>
    </section>

    <x-sss-bolum :ssler="$ssler" />
    <x-cta-bandi />
@endsection
