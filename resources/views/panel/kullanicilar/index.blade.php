@extends('layouts.panel')
@section('baslik', 'Kullanıcılar')

@section('content')
    <x-panel.baslik baslik="Kullanıcı & Rol Yönetimi" aciklama="Admin tam yetkili; Editör içerik ekler/düzenler.">
        <x-slot:aksiyon><x-panel.ekle-btn :href="route('panel.kullanicilar.create')" label="Yeni Kullanıcı" /></x-slot:aksiyon>
    </x-panel.baslik>
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @foreach($kullanicilar as $k)
            <div class="flex items-center gap-4 p-4">
                <span class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-gold-light material-symbols-outlined">{{ $k->rol==='admin' ? 'shield_person' : 'person' }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-on-surface font-medium truncate">{{ $k->name }} @if(!$k->aktif)<span class="text-[10px] text-error">(pasif)</span>@endif</p>
                    <p class="text-xs text-stone-grey truncate">{{ $k->email }}</p>
                </div>
                <span class="text-[10px] px-2 py-1 rounded-full {{ $k->rol==='admin' ? 'bg-gold-light/15 text-gold-light' : 'bg-surface-variant text-stone-grey' }} uppercase">{{ $k->rol==='admin' ? 'Yönetici' : 'Editör' }}</span>
                <a href="{{ route('panel.kullanicilar.edit', $k) }}" class="text-stone-grey hover:text-gold-light p-1.5"><span class="material-symbols-outlined">edit</span></a>
                @if($k->id !== auth()->id())<x-panel.sil-btn :action="route('panel.kullanicilar.destroy', $k)" />@endif
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $kullanicilar->links() }}</div>
@endsection
