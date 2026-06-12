@extends('layouts.site')

@section('title', $sayfa?->meta_title ?: $sayfa?->baslik . ' | Sekmen Zemin Tasarım')
@section('meta_desc', $sayfa?->meta_desc)

@section('content')
    <section class="pt-16 pb-20 max-w-3xl mx-auto px-margin-mobile">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">{{ $sayfa?->baslik }}</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-md text-cream-white uppercase tracking-tight mb-8">{{ $sayfa?->baslik }}</h1>
        <div class="space-y-4 text-stone-grey leading-relaxed prose-invert">
            {!! $sayfa?->icerik !!}
        </div>
    </section>
    <x-sss-bolum :ssler="$ssler ?? collect()" />
@endsection
