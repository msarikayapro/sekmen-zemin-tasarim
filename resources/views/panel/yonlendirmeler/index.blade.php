@extends('layouts.panel')
@section('baslik', '301 Yönlendirmeler')

@section('content')
    <x-panel.baslik baslik="301 Yönlendirmeler" aciklama="Eski sekmenyapi.com URL'lerini yeni adreslere yönlendirin (SEO geçişi)." />

    <x-panel.card baslik="Yeni Yönlendirme">
        <form method="POST" action="{{ route('panel.yonlendirmeler.store') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            @csrf
            <div class="sm:col-span-2"><x-panel.input label="Eski URL" name="eski_url" placeholder="urunler.html veya /eski-yol" required /></div>
            <x-panel.input label="Yeni URL" name="yeni_url" placeholder="/urunler" required />
            <div class="flex gap-2">
                <select name="tip" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-3 text-on-surface"><option value="301">301</option><option value="302">302</option></select>
                <button class="bg-gold-light text-background px-4 rounded-lg font-bold material-symbols-outlined">add</button>
            </div>
        </form>
    </x-panel.card>

    <div class="mt-6 bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($yonlendirmeler as $y)
            <div class="flex items-center gap-3 p-4 text-sm">
                <span class="flex-1 min-w-0 truncate text-stone-grey">{{ $y->eski_url }}</span>
                <span class="material-symbols-outlined text-gold-light text-base">arrow_forward</span>
                <span class="flex-1 min-w-0 truncate text-on-surface">{{ $y->yeni_url }}</span>
                <span class="text-[10px] px-2 py-0.5 rounded bg-surface-variant text-stone-grey">{{ $y->tip }}</span>
                <form method="POST" action="{{ route('panel.yonlendirmeler.toggle', $y) }}" class="inline">@csrf @method('PUT')
                    <button class="text-{{ $y->aktif ? 'success' : 'stone-grey' }} p-1"><span class="material-symbols-outlined">{{ $y->aktif ? 'toggle_on' : 'toggle_off' }}</span></button>
                </form>
                <x-panel.sil-btn :action="route('panel.yonlendirmeler.destroy', $y)" />
            </div>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz yönlendirme yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $yonlendirmeler->links() }}</div>
@endsection
