@extends('layouts.panel')
@section('baslik', 'Banner / Slider')

@section('content')
    <x-panel.baslik baslik="Banner / Slider" aciklama="Ana sayfa hero görselleri.">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.bannerlar.create')" label="Yeni Banner" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($bannerlar as $b)
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl overflow-hidden">
                <img src="{{ gorsel($b->gorsel) }}" class="w-full aspect-video object-cover" alt="">
                <div class="p-4 flex items-center justify-between">
                    <div><p class="text-on-surface text-sm font-medium">{{ $b->baslik ?: 'Başlıksız' }}</p>
                        <span class="text-[10px] px-2 py-0.5 rounded-full {{ $b->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase">{{ $b->durum }}</span></div>
                    <div class="flex">
                        <a href="{{ route('panel.bannerlar.edit', $b) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                        <x-panel.sil-btn :action="route('panel.bannerlar.destroy', $b)" />
                    </div>
                </div>
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey col-span-2">Henüz banner yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $bannerlar->links() }}</div>
@endsection
