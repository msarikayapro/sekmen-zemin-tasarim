@extends('layouts.panel')
@section('baslik', 'Teklif Talepleri')

@section('content')
    <x-panel.baslik baslik="Teklif Talepleri" aciklama="Gelen lead'ler ve durum takibi.">
        <x-slot:aksiyon>
            <a href="{{ route('panel.talepler.export') }}" class="inline-flex items-center gap-2 bg-surface-variant text-on-surface px-4 py-2.5 rounded-lg text-xs font-label-caps uppercase hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-lg">download</span> CSV İndir
            </a>
        </x-slot:aksiyon>
    </x-panel.baslik>

    <form method="GET" class="flex flex-wrap gap-3 mb-5">
        <input name="q" value="{{ request('q') }}" placeholder="Ad veya telefon ara..." class="flex-1 max-w-xs bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-on-surface focus:border-gold-light focus:outline-none">
        <select name="durum" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-on-surface">
            <option value="">Tüm Durumlar</option>
            @foreach($durumlar as $k => $v)<option value="{{ $k }}" @selected($aktifDurum===$k)>{{ $v }}</option>@endforeach
        </select>
        <button class="bg-surface-variant text-on-surface px-4 rounded-lg material-symbols-outlined">search</button>
    </form>

    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @forelse($talepler as $t)
            <a href="{{ route('panel.talepler.show', $t) }}" class="flex items-center gap-4 p-4 hover:bg-surface-variant/30 {{ $t->durum==='yeni' ? 'bg-gold-light/5' : '' }}">
                <span class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-gold-light shrink-0 material-symbols-outlined">person</span>
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium truncate">{{ $t->ad }}
                        @if($t->durum==='yeni')<span class="text-[10px] bg-gold-light text-background px-1.5 rounded ml-1">YENİ</span>@endif
                    </p>
                    <p class="text-xs text-stone-grey truncate">{{ $t->telefon }} @if($t->ilgi_alani || $t->urun)· {{ $t->ilgi_alani ?: $t->urun?->ad }}@endif</p>
                </div>
                <div class="text-right hidden sm:block">
                    <span class="text-[10px] px-2 py-1 rounded-full bg-surface-variant text-on-surface-variant uppercase">{{ $durumlar[$t->durum] ?? $t->durum }}</span>
                    <p class="text-[10px] text-stone-grey mt-1">{{ $t->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <span class="material-symbols-outlined text-stone-grey">chevron_right</span>
            </a>
        @empty
            <p class="p-10 text-center text-stone-grey">Henüz teklif talebi yok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $talepler->links() }}</div>
@endsection
