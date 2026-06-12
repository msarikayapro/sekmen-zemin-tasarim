@extends('layouts.panel')
@section('baslik', 'Ürün Kataloğu')

@section('content')
    <x-panel.baslik baslik="Ürün Kataloğu" aciklama="{{ $urunler->total() }} ürün · sürükleyerek sıralayın.">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.urunler.create')" label="Yeni Ürün" /></x-slot:aksiyon>
    </x-panel.baslik>

    <form method="GET" class="flex gap-3 mb-5">
        <input name="q" value="{{ request('q') }}" placeholder="Ürün ara..." class="flex-1 max-w-xs bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-on-surface focus:border-gold-light focus:outline-none">
        <select name="durum" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-on-surface">
            <option value="">Tüm Durumlar</option>
            <option value="yayin" @selected(request('durum')==='yayin')>Yayında</option>
            <option value="taslak" @selected(request('durum')==='taslak')>Taslak</option>
        </select>
        <button class="bg-surface-variant text-on-surface px-4 rounded-lg material-symbols-outlined">search</button>
    </form>

    <div class="bg-surface-container-low border border-surface-variant rounded-2xl overflow-hidden">
        <ul id="urun-liste" class="divide-y divide-surface-variant/60">
            @forelse($urunler as $urun)
                <li class="flex items-center gap-4 p-3 md:p-4 hover:bg-surface-variant/30" data-id="{{ $urun->id }}">
                    <span class="material-symbols-outlined text-stone-grey cursor-grab handle hidden md:block">drag_indicator</span>
                    <img src="{{ gorsel($urun->kapak) }}" class="w-14 h-14 rounded-lg object-cover shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-on-surface font-medium truncate">{{ $urun->ad }}
                            @if($urun->one_cikan)<span class="material-symbols-outlined text-gold-light text-sm align-middle">star</span>@endif
                        </p>
                        <p class="text-xs text-stone-grey">{{ $urun->kategoriler->pluck('ad')->implode(', ') ?: 'Kategorisiz' }}</p>
                    </div>
                    <span class="text-[10px] px-2 py-1 rounded-full {{ $urun->durum==='yayin' ? 'bg-success/15 text-success' : 'bg-stone-grey/15 text-stone-grey' }} uppercase hidden sm:inline">{{ $urun->durum }}</span>
                    <a href="{{ route('panel.urunler.edit', $urun) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                    <x-panel.sil-btn :action="route('panel.urunler.destroy', $urun)" />
                </li>
            @empty
                <li class="p-10 text-center text-stone-grey">Henüz ürün yok. <a href="{{ route('panel.urunler.create') }}" class="text-gold-light">İlk ürünü ekleyin</a>.</li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">{{ $urunler->links() }}</div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script>
        const liste = document.getElementById('urun-liste');
        if (liste && window.Sortable) {
            new Sortable(liste, {
                handle: '.handle', animation: 150,
                onEnd() {
                    const sira = [...liste.children].map(li => li.dataset.id).filter(Boolean);
                    fetch('{{ route('panel.urunler.sirala') }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({sira})
                    });
                }
            });
        }
    </script>
    @endpush
@endsection
