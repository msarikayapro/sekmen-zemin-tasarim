@extends('layouts.panel')
@section('baslik', 'Hizmetler')

@section('content')
    <x-panel.baslik baslik="Hizmetler">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.hizmetler.create')" label="Yeni Hizmet" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($hizmetler as $h)
            <div class="flex items-center gap-4 p-4">
                <span class="material-symbols-outlined text-gold-light text-3xl w-10 text-center">{{ $h->ikon ?: 'construction' }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium">{{ $h->ad }}</p>
                    <p class="text-xs text-stone-grey truncate">{{ \Illuminate\Support\Str::limit($h->aciklama, 80) }}</p>
                </div>
                <span class="text-[10px] px-2 py-1 rounded-full {{ $h->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase">{{ $h->durum }}</span>
                <a href="{{ route('panel.hizmetler.edit', $h) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                <x-panel.sil-btn :action="route('panel.hizmetler.destroy', $h)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz hizmet yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $hizmetler->links() }}</div>
@endsection
