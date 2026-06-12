@extends('layouts.site')

@section('title', 'Ürün Kataloğu — Parke Taşı Modelleri | Sekmen Zemin Tasarım')
@section('meta_desc', '28 farklı parke ve kilit taşı modeli. Teknik özellikler, ebatlar ve kullanım alanlarıyla Sekmen Zemin Tasarım ürün kataloğu.')

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">Ürünler</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight">Ürün Kataloğu</h1>
        <p class="text-stone-grey mt-3 max-w-2xl">Dayanıklılık ve estetiği birleştiren parke taşı modellerimiz. Her ürünün teknik detaylarını inceleyin ve dilediğiniz model için teklif alın.</p>

        {{-- Kategori filtre --}}
        <div class="flex flex-wrap gap-3 mt-8">
            <a href="{{ route('urunler.index') }}" class="px-5 py-2 rounded-full text-sm font-label-caps uppercase border transition-colors {{ ! $aktifKategori ? 'bg-gold-light text-background border-gold-light' : 'border-surface-variant text-stone-grey hover:border-gold-light hover:text-gold-light' }}">Tümü</a>
            @foreach($kategoriler as $kat)
                <a href="{{ route('urunler.index', ['kategori' => $kat->slug]) }}" class="px-5 py-2 rounded-full text-sm font-label-caps uppercase border transition-colors {{ $aktifKategori === $kat->slug ? 'bg-gold-light text-background border-gold-light' : 'border-surface-variant text-stone-grey hover:border-gold-light hover:text-gold-light' }}">{{ $kat->ad }}</a>
            @endforeach
        </div>
    </section>

    <section class="pb-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        @if($urunler->isEmpty())
            <p class="text-stone-grey text-center py-20">Bu kategoride henüz ürün bulunmuyor.</p>
        @else
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-gutter">
                @foreach($urunler as $urun)
                    <x-urun-kart :urun="$urun" />
                @endforeach
            </div>
            <div class="mt-12">{{ $urunler->links() }}</div>
        @endif
    </section>

    <x-sss-bolum :ssler="$ssler" />
    <x-cta-bandi />
@endsection
