@extends('layouts.site')

@section('title', $sayfa->meta_title ?: $sayfa->baslik_h1 . ' | Sekmen Zemin Tasarım')
@section('meta_desc', $sayfa->meta_desc)

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">{{ $sayfa->sehir }}</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight max-w-3xl">{{ $sayfa->baslik_h1 }}</h1>
    </section>

    <section class="pb-16 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <div class="lg:col-span-2 space-y-5 text-stone-grey leading-relaxed prose-invert">
            {!! $sayfa->icerik !!}
        </div>
        {{-- Sabit teklif bloğu --}}
        <div class="lg:sticky lg:top-28 self-start bg-surface-container-high rounded-2xl p-6 border border-gold-light/20 space-y-4">
            <h3 class="font-headline-md text-lg text-cream-white">Ücretsiz Teklif Alın</h3>
            <p class="text-stone-grey text-sm">{{ $sayfa->sehir }} bölgesinde {{ $sayfa->urun_tipi }} uygulaması için hemen iletişime geçin.</p>
            <a href="{{ route('iletisim') }}" class="block text-center bg-gold-light text-background font-bold py-3 rounded-lg uppercase text-sm">Teklif Al</a>
            <a href="{{ tel_link(ayar('telefon')) }}" data-track="phone_click" class="block text-center border border-gold-light text-gold-light font-bold py-3 rounded-lg uppercase text-sm">{{ ayar('telefon') }}</a>
        </div>
    </section>

    @if($urunler->isNotEmpty())
    <section class="pb-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <x-bolum-baslik baslik="Ürün Modellerimiz" :ortala="false" />
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-gutter">
            @foreach($urunler as $u)<x-urun-kart :urun="$u" />@endforeach
        </div>
    </section>
    @endif

    <x-cta-bandi />
@endsection
