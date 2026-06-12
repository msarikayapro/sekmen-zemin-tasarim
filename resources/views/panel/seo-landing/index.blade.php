@extends('layouts.panel')
@section('baslik', 'SEO Landing')

@section('content')
    <x-panel.baslik baslik="SEO Landing Sayfaları" aciklama="Şehir + ürün şablonlu sayfalar (otomatik meta + URL).">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.seo-landing.create')" label="Yeni Sayfa" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($sayfalar as $s)
            <div class="flex items-center gap-4 p-4">
                <span class="material-symbols-outlined text-gold-light">travel_explore</span>
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium truncate">{{ $s->baslik_h1 }}</p>
                    <a href="{{ url($s->slug) }}" target="_blank" class="text-xs text-stone-grey hover:text-gold-light">/{{ $s->slug }}</a>
                </div>
                <span class="text-[10px] px-2 py-1 rounded-full {{ $s->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase">{{ $s->durum }}</span>
                <a href="{{ route('panel.seo-landing.edit', $s) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                <x-panel.sil-btn :action="route('panel.seo-landing.destroy', $s)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz landing sayfası yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $sayfalar->links() }}</div>
@endsection
