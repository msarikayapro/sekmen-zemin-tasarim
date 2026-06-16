@extends('layouts.panel')
@section('baslik', 'Vitrin Yönetimi')

@section('content')
    <x-panel.baslik baslik="Vitrin Yönetimi" aciklama="{{ $showcases->count() }} kayıt · sürükleyerek sıralayın. Ana sayfadaki vitrin galerisini besler.">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.showcases.create')" label="Yeni Vitrin" /></x-slot:aksiyon>
    </x-panel.baslik>

    @if($showcases->isEmpty())
        <div class="bg-surface-container-low border border-surface-variant rounded-2xl p-10 text-center text-stone-grey">
            Henüz vitrin kaydı yok. <a href="{{ route('panel.showcases.create') }}" class="text-gold-light">İlk kaydı ekleyin</a>.
        </div>
    @else
        <ul id="vitrin-liste" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($showcases as $s)
                <li class="group relative bg-surface-container-low border border-surface-variant rounded-2xl overflow-hidden" data-id="{{ $s->id }}">
                    <div class="relative aspect-[3/4] bg-surface-container-lowest">
                        <img src="{{ gorsel($s->kapak) }}" class="w-full h-full object-cover" alt="">
                        {{-- Tip rozeti --}}
                        <span class="absolute top-2 left-2 flex items-center gap-1 text-[10px] font-bold uppercase px-2 py-1 rounded-full bg-background/80 text-gold-light backdrop-blur">
                            <span class="material-symbols-outlined text-sm">{{ $s->isVideo() ? 'play_circle' : 'image' }}</span>{{ $s->isVideo() ? 'Video' : 'Görsel' }}
                        </span>
                        {{-- Aktiflik --}}
                        @unless($s->is_active)
                            <span class="absolute top-2 right-2 text-[10px] font-bold uppercase px-2 py-1 rounded-full bg-stone-grey/30 text-cream-white backdrop-blur">Pasif</span>
                        @endunless
                        {{-- Sürükleme tutamağı --}}
                        <span class="handle absolute bottom-2 left-2 cursor-grab text-cream-white/80 bg-background/60 rounded-lg p-1 material-symbols-outlined">drag_indicator</span>
                    </div>
                    <div class="flex items-center justify-between px-3 py-2">
                        <span class="text-xs text-stone-grey">#{{ $s->order }}</span>
                        <div class="flex">
                            <a href="{{ route('panel.showcases.edit', $s) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined text-xl">edit</span></a>
                            <x-panel.sil-btn :action="route('panel.showcases.destroy', $s)" />
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script>
        const liste = document.getElementById('vitrin-liste');
        if (liste && window.Sortable) {
            new Sortable(liste, {
                handle: '.handle', animation: 150,
                onEnd() {
                    const sira = [...liste.children].map(li => li.dataset.id).filter(Boolean);
                    fetch('{{ route('panel.showcases.sirala') }}', {
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
