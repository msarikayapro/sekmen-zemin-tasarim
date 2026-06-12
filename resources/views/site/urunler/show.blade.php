@extends('layouts.site')

@section('title', $urun->meta_title ?: $urun->ad . ' Parke Taşı | Sekmen Zemin Tasarım')
@section('meta_desc', $urun->meta_desc ?: \Illuminate\Support\Str::limit(strip_tags($urun->aciklama), 155))
@section('og_image', $urun->og_image ? gorsel($urun->og_image) : gorsel($urun->kapak))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org', '@type' => 'Product',
    'name' => $urun->ad, 'description' => strip_tags($urun->aciklama),
    'image' => gorsel($urun->kapak), 'brand' => ['@type' => 'Brand', 'name' => 'Sekmen Zemin Tasarım'],
    'category' => $urun->kategoriler->pluck('ad')->implode(', '),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        {{-- Galeri --}}
        <div class="space-y-4" data-gallery>
            <div class="aspect-[4/3] rounded-2xl overflow-hidden border border-surface-variant bg-surface-container shadow-2xl">
                <img data-gallery-main src="{{ gorsel($urun->kapak) }}" alt="{{ $urun->ad }}" class="w-full h-full object-cover">
            </div>
            @if($urun->gorseller->isNotEmpty())
                <div class="grid grid-cols-4 gap-3">
                    @php($tumGorseller = collect([$urun->kapak])->filter()->merge($urun->gorseller->pluck('yol'))->unique()->take(8))
                    @foreach($tumGorseller as $i => $g)
                        <button type="button" data-gallery-thumb data-full="{{ gorsel($g) }}" class="aspect-square rounded-lg border-2 overflow-hidden {{ $i===0 ? 'border-gold-light' : 'border-surface-variant hover:border-gold-light' }} transition-colors">
                            <img src="{{ gorsel($g) }}" alt="{{ $urun->ad }} {{ $i+1 }}" loading="lazy" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Bilgi --}}
        <div class="flex flex-col">
            <nav class="flex flex-wrap gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
                <a href="{{ route('urunler.index') }}" class="hover:text-gold-light">Ürünler</a>
                @if($urun->kategoriler->first())<span>/</span><a href="{{ route('urunler.index',['kategori'=>$urun->kategoriler->first()->slug]) }}" class="hover:text-gold-light">{{ $urun->kategoriler->first()->ad }}</a>@endif
                <span>/</span><span class="text-on-surface">{{ $urun->ad }}</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-white mb-5 uppercase tracking-tight">{{ $urun->ad }}</h1>
            @if($urun->aciklama)<p class="font-body-lg text-stone-grey mb-8 leading-relaxed">{{ $urun->aciklama }}</p>@endif

            {{-- Teknik özellik tablosu --}}
            <div class="border border-surface-variant rounded-xl overflow-hidden mb-8 bg-surface-container-low text-sm">
                @php($satirlar = array_filter([
                    'Ebat' => trim(($urun->ebat_en ? $urun->ebat_en : '') . ($urun->ebat_boy ? ' x ' . $urun->ebat_boy : ''), ' x'),
                    'Kalınlık' => $urun->kalinlik,
                    'm² Adedi' => $urun->m2_adet,
                    'Palet Bilgisi' => $urun->palet_bilgi,
                    'Dayanım' => $urun->dayanim,
                    'Don Direnci' => $urun->don_direnci,
                ]))
                @foreach($satirlar as $etiket => $deger)
                    <div class="grid grid-cols-2 p-4 {{ $loop->even ? 'bg-surface-container' : '' }} {{ ! $loop->last ? 'border-b border-surface-variant' : '' }}">
                        <span class="font-label-caps text-stone-grey uppercase text-[11px]">{{ $etiket }}</span>
                        <span class="text-on-surface">{{ $deger }}</span>
                    </div>
                @endforeach
                @if($urun->renk_secenekleri)
                    <div class="grid grid-cols-2 p-4 border-t border-surface-variant">
                        <span class="font-label-caps text-stone-grey uppercase text-[11px]">Renkler</span>
                        <span class="text-on-surface">{{ implode(', ', $urun->renk_secenekleri) }}</span>
                    </div>
                @endif
                @if($urun->kullanim_alanlari)
                    <div class="grid grid-cols-2 p-4 bg-surface-container border-t border-surface-variant">
                        <span class="font-label-caps text-stone-grey uppercase text-[11px]">Kullanım</span>
                        <span class="text-on-surface">{{ implode(', ', $urun->kullanim_alanlari) }}</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('iletisim', ['urun' => $urun->id]) }}" data-track="urun_view" class="btn-sweep flex-1 bg-gold-light text-background font-bold py-5 rounded-xl uppercase tracking-widest hover:bg-gold-dark transition-colors flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">request_quote</span> Bu Ürün İçin Teklif Al
                </a>
                <a href="{{ whatsapp_link('Merhaba, ' . $urun->ad . ' ürünü hakkında bilgi almak istiyorum.') }}" data-track="whatsapp_click" target="_blank" class="sm:w-16 flex items-center justify-center bg-[#25D366] text-white py-5 rounded-xl" aria-label="WhatsApp">
                    <span class="material-symbols-outlined">chat</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Video --}}
    @if($urun->video_url)
    <section class="bg-surface-container-low py-16">
        <div class="max-w-4xl mx-auto px-margin-mobile text-center">
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-md mb-8 uppercase text-cream-white">Üretim ve Uygulama</h2>
            <div class="aspect-video rounded-2xl overflow-hidden border-4 border-surface-variant shadow-2xl">
                <iframe src="{{ \Illuminate\Support\Str::replace(['watch?v=','youtu.be/'], ['embed/','youtube.com/embed/'], $urun->video_url) }}" class="w-full h-full" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    </section>
    @endif

    {{-- İlgili ürünler --}}
    @if($ilgili->isNotEmpty())
    <section class="py-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="flex justify-between items-end mb-10">
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-md uppercase text-cream-white">Benzer Modeller</h2>
            <a href="{{ route('urunler.index') }}" class="text-gold-light font-label-caps text-sm uppercase hover:underline underline-offset-8">Tümünü Gör</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-gutter">
            @foreach($ilgili as $u)<x-urun-kart :urun="$u" />@endforeach
        </div>
    </section>
    @endif

    {{-- Ürün detay SSS'leri --}}
    <x-sss-bolum :ssler="$ssler" baslik="{{ $urun->ad }} Hakkında Sıkça Sorulanlar" />
@endsection
