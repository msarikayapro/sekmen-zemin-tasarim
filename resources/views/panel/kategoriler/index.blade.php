@extends('layouts.panel')
@section('baslik', 'Kategoriler')

@section('content')
    <x-panel.baslik baslik="Kategoriler" aciklama="Ürün grupları (many-to-many).">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.kategoriler.create')" label="Yeni Kategori" /></x-slot:aksiyon>
    </x-panel.baslik>

    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($kategoriler as $kat)
            <div class="flex items-center gap-4 p-4">
                <img src="{{ gorsel($kat->gorsel) }}" class="w-12 h-12 rounded-lg object-cover shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium">{{ $kat->ad }}</p>
                    <p class="text-xs text-stone-grey">/{{ $kat->slug }} · {{ $kat->urunler_count }} ürün</p>
                </div>
                <a href="{{ route('panel.kategoriler.edit', $kat) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                <x-panel.sil-btn :action="route('panel.kategoriler.destroy', $kat)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz kategori yok.</p>
        @endforelse
    </div>
@endsection
