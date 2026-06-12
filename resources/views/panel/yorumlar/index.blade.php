@extends('layouts.panel')
@section('baslik', 'Müşteri Yorumları')

@section('content')
    <x-panel.baslik baslik="Müşteri Yorumları">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.yorumlar.create')" label="Yeni Yorum" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($yorumlar as $y)
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl p-5">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-3">
                        <img src="{{ gorsel($y->gorsel) }}" class="w-10 h-10 rounded-full object-cover" alt="">
                        <div><p class="text-on-surface font-medium">{{ $y->ad }}</p><p class="text-xs text-stone-grey">{{ $y->unvan }}</p></div>
                    </div>
                    <div class="text-gold-light flex">@for($i=0;$i<($y->puan??5);$i++)<span class="material-symbols-outlined fill text-sm">star</span>@endfor</div>
                </div>
                <p class="text-stone-grey text-sm italic mb-3">"{{ \Illuminate\Support\Str::limit($y->icerik, 120) }}"</p>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] px-2 py-1 rounded-full {{ $y->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase">{{ $y->durum }} @if($y->one_cikan)· ★ öne çıkan @endif</span>
                    <div class="flex">
                        <a href="{{ route('panel.yorumlar.edit', $y) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                        <x-panel.sil-btn :action="route('panel.yorumlar.destroy', $y)" />
                    </div>
                </div>
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey col-span-2">Henüz yorum yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $yorumlar->links() }}</div>
@endsection
