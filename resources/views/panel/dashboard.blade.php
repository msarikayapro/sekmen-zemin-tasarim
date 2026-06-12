@extends('layouts.panel')
@section('baslik', 'Panel')

@section('content')
    <div class="flex justify-between items-end mb-6">
        <div>
            <h1 class="font-headline-md text-2xl md:text-headline-md text-cream-white">Hoş geldiniz, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-stone-grey text-sm mt-1">İşte panelinizin özeti.</p>
        </div>
        <span class="font-label-caps text-gold-light text-xs hidden sm:flex items-center gap-1"><span class="w-2 h-2 bg-success rounded-full animate-pulse"></span> Canlı</span>
    </div>

    {{-- Özet kartları --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bento-card rounded-2xl p-4 h-32 flex flex-col justify-between relative overflow-hidden">
            <div>
                <span class="material-symbols-outlined text-gold-light text-3xl">request_quote</span>
                <p class="font-label-caps text-[10px] text-stone-grey mt-2 uppercase">Bekleyen Teklif</p>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ $bekleyenTeklif }}</span>
                @if($bekleyenTeklif > 0)<span class="text-[10px] bg-gold-light/20 text-gold-light px-2 py-0.5 rounded-full">Yeni</span>@endif
            </div>
            <span class="material-symbols-outlined absolute -right-3 -bottom-3 text-7xl opacity-5">trending_up</span>
        </div>
        <div class="bento-card rounded-2xl p-4 h-32 flex flex-col justify-between">
            <div><span class="material-symbols-outlined text-gold-light text-3xl">category</span>
                <p class="font-label-caps text-[10px] text-stone-grey mt-2 uppercase">Ürün</p></div>
            <span class="text-3xl font-bold text-on-surface">{{ $urunSayisi }}</span>
        </div>
        <div class="bento-card rounded-2xl p-4 h-32 flex flex-col justify-between">
            <div><span class="material-symbols-outlined text-gold-light text-3xl">architecture</span>
                <p class="font-label-caps text-[10px] text-stone-grey mt-2 uppercase">Proje</p></div>
            <span class="text-3xl font-bold text-on-surface">{{ $projeSayisi }}</span>
        </div>
        <div class="bento-card rounded-2xl p-4 h-32 flex flex-col justify-between">
            <div><span class="material-symbols-outlined text-gold-light text-3xl">reviews</span>
                <p class="font-label-caps text-[10px] text-stone-grey mt-2 uppercase">Yorum</p></div>
            <span class="text-3xl font-bold text-on-surface">{{ $yorumSayisi }}</span>
        </div>
    </div>

    {{-- Hızlı işlemler --}}
    <h2 class="font-label-caps text-stone-grey uppercase text-xs mb-4">Hızlı İşlemler</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @php
            $aksiyonlar = [
                ['panel.urunler.create', 'add_box', 'Yeni Ürün'],
                ['panel.talepler.index', 'description', 'Teklifler'],
                ['panel.projeler.create', 'architecture', 'Proje Ekle'],
                ['panel.oncesi-sonrasi.create', 'compare', 'Öncesi/Sonrası'],
            ];
        @endphp
        @foreach($aksiyonlar as [$rota, $ikon, $etiket])
            <a href="{{ route($rota) }}" class="gold-press flex flex-col items-center justify-center p-6 bg-surface-container-high rounded-2xl border border-surface-variant transition-all">
                <span class="w-14 h-14 bg-gold-light text-background rounded-full flex items-center justify-center mb-3 shadow-lg shadow-gold-dark/20">
                    <span class="material-symbols-outlined text-3xl fill">{{ $ikon }}</span>
                </span>
                <span class="font-label-caps text-on-surface text-xs uppercase text-center">{{ $etiket }}</span>
            </a>
        @endforeach
    </div>

    {{-- Son talepler --}}
    <x-panel.card baslik="Son Teklif Talepleri">
        @forelse($sonTalepler as $talep)
            <a href="{{ route('panel.talepler.show', $talep) }}" class="flex items-center justify-between p-3 -mx-2 rounded-xl hover:bg-surface-variant transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-full bg-surface-container-high flex items-center justify-center text-gold-light shrink-0 material-symbols-outlined text-lg">person</span>
                    <div class="min-w-0">
                        <p class="text-on-surface text-sm truncate">{{ $talep->ad }} @if($talep->durum==='yeni')<span class="text-[10px] bg-gold-light text-background px-1.5 rounded ml-1">YENİ</span>@endif</p>
                        <p class="text-stone-grey text-xs">{{ $talep->telefon }} · {{ $talep->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-stone-grey">chevron_right</span>
            </a>
        @empty
            <p class="text-stone-grey text-sm">Henüz teklif talebi yok.</p>
        @endforelse
    </x-panel.card>
@endsection
