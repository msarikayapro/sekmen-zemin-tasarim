@extends('layouts.site')

@section('title', 'Hizmetlerimiz | Sekmen Zemin Tasarım')
@section('meta_desc', 'Parke taşı uygulama, peyzaj, altyapı, bordür ve danışmanlık hizmetleri. Konya merkezli profesyonel zemin çözümleri.')

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">Hizmetler</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight">Hizmetlerimiz</h1>
        <p class="text-stone-grey mt-3 max-w-2xl">Keşiften teslime, zemininizin her aşamasında yanınızdayız. Profesyonel ekibimizle anahtar teslim çözümler sunuyoruz.</p>
    </section>

    <section class="pb-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-gutter">
        @foreach($hizmetler as $hizmet)
            <div class="bg-surface-container border border-surface-variant/40 rounded-2xl p-8 flex gap-6 gold-glow reveal">
                <span class="material-symbols-outlined text-gold-light text-5xl shrink-0">{{ $hizmet->ikon ?: 'construction' }}</span>
                <div class="space-y-3">
                    <h3 class="font-headline-md text-xl text-cream-white">{{ $hizmet->ad }}</h3>
                    <p class="text-stone-grey text-sm leading-relaxed">{{ $hizmet->aciklama }}</p>
                    <a href="{{ route('iletisim', ['urun' => null]) }}?hizmet={{ urlencode($hizmet->ad) }}" class="inline-flex items-center gap-2 text-gold-light font-label-caps text-xs uppercase">Teklif Al <span class="material-symbols-outlined text-base">arrow_forward</span></a>
                </div>
            </div>
        @endforeach
    </section>

    <x-sss-bolum :ssler="$ssler" />
    <x-cta-bandi />
@endsection
