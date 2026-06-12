@extends('layouts.panel')
@section('baslik', 'Öncesi / Sonrası')

@section('content')
    <x-panel.baslik baslik="Öncesi / Sonrası Galeri">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.oncesi-sonrasi.create')" label="Yeni Kayıt" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($kayitlar as $k)
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl p-4">
                <div class="flex gap-2 mb-3">
                    <img src="{{ gorsel($k->oncesi_gorsel) }}" class="w-1/2 aspect-video object-cover rounded-lg" alt="öncesi">
                    <img src="{{ gorsel($k->sonrasi_gorsel) }}" class="w-1/2 aspect-video object-cover rounded-lg" alt="sonrası">
                </div>
                <div class="flex items-center justify-between">
                    <div><p class="text-on-surface text-sm font-medium">{{ $k->baslik ?: 'Başlıksız' }}</p><p class="text-xs text-stone-grey">{{ $k->proje?->baslik }}</p></div>
                    <div class="flex">
                        <a href="{{ route('panel.oncesi-sonrasi.edit', $k) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                        <x-panel.sil-btn :action="route('panel.oncesi-sonrasi.destroy', $k)" />
                    </div>
                </div>
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey col-span-2">Henüz kayıt yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $kayitlar->links() }}</div>
@endsection
