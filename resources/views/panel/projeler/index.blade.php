@extends('layouts.panel')
@section('baslik', 'Projeler')

@section('content')
    <x-panel.baslik baslik="Projeler / Referanslar">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.projeler.create')" label="Yeni Proje" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($projeler as $p)
            <div class="flex items-center gap-4 p-4">
                <img src="{{ gorsel($p->kapak) }}" class="w-14 h-14 rounded-lg object-cover shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium truncate">{{ $p->baslik }} @if($p->one_cikan)<span class="material-symbols-outlined text-gold-light text-sm align-middle">star</span>@endif</p>
                    <p class="text-xs text-stone-grey">{{ \App\Models\Proje::TIPLER[$p->tip] ?? '' }} · {{ $p->konum }}</p>
                </div>
                <span class="text-[10px] px-2 py-1 rounded-full {{ $p->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase hidden sm:inline">{{ $p->durum }}</span>
                <a href="{{ route('panel.projeler.edit', $p) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                <x-panel.sil-btn :action="route('panel.projeler.destroy', $p)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz proje yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $projeler->links() }}</div>
@endsection
