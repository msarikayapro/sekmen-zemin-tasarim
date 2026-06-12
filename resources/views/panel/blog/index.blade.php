@extends('layouts.panel')
@section('baslik', 'Blog')

@section('content')
    <x-panel.baslik baslik="Blog" aciklama="SEO içerik (faz 2).">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.blog.create')" label="Yeni Yazı" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($yazilar as $y)
            <div class="flex items-center gap-4 p-4">
                <img src="{{ gorsel($y->kapak) }}" class="w-14 h-14 rounded-lg object-cover shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium truncate">{{ $y->baslik }}</p>
                    <p class="text-xs text-stone-grey">{{ $y->kategori }} · {{ $y->created_at->format('d.m.Y') }}</p>
                </div>
                <span class="text-[10px] px-2 py-1 rounded-full {{ $y->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase">{{ $y->durum }}</span>
                <a href="{{ route('panel.blog.edit', $y) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                <x-panel.sil-btn :action="route('panel.blog.destroy', $y)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz blog yazısı yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $yazilar->links() }}</div>
@endsection
