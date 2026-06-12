@extends('layouts.panel')
@section('baslik', 'SSS')

@section('content')
    <x-panel.baslik baslik="Sıkça Sorulan Sorular" aciklama="Kategori bazlı, sayfaya atanabilir, otomatik FAQ schema.">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.sss.create')" label="Yeni Soru" /></x-slot:aksiyon>
    </x-panel.baslik>

    @forelse($gruplar as $kategori => $ssler)
        <div class="mb-6">
            <h3 class="font-label-caps text-gold-light uppercase text-xs mb-3">{{ $kategori }} <span class="text-stone-grey">({{ $ssler->count() }})</span></h3>
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
                @foreach($ssler as $sss)
                    <div class="flex items-center gap-4 p-4">
                        <span class="material-symbols-outlined {{ $sss->durum==='yayin' ? 'text-success' : 'text-stone-grey' }}">{{ $sss->durum==='yayin' ? 'help' : 'help_outline' }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-on-surface text-sm font-medium truncate">{{ $sss->soru }}</p>
                            <p class="text-xs text-stone-grey">
                                @if($sss->sayfalar->isEmpty())
                                    <span class="text-gold-light/70">Tüm sayfalarda</span>
                                @else
                                    {{ collect($sss->sayfalar->pluck('sayfa_anahtar'))->map(fn($s)=>\App\Models\Sss::SAYFALAR[$s] ?? $s)->implode(', ') }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('panel.sss.edit', $sss) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                        <x-panel.sil-btn :action="route('panel.sss.destroy', $sss)" />
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="p-10 text-center text-stone-grey bg-surface-container-low rounded-2xl border border-surface-variant">Henüz soru-cevap yok.</p>
    @endforelse
@endsection
