@extends('layouts.panel')
@section('baslik', 'İçerik Sayfaları')

@section('content')
    <x-panel.baslik baslik="İçerik Sayfaları" aciklama="Statik sayfa ve ana sayfa blok içerikleri." />
    <div class="bg-surface-container-low border border-surface-variant rounded-2xl divide-y divide-surface-variant/60">
        @foreach($sayfalar as $s)
            <a href="{{ route('panel.sayfalar.edit', $s) }}" class="flex items-center gap-4 p-4 hover:bg-surface-variant/30">
                <span class="material-symbols-outlined text-gold-light">{{ ['home'=>'home','about'=>'info','kvkk'=>'gavel','cerez'=>'cookie'][$s->anahtar] ?? 'description' }}</span>
                <div class="flex-1"><p class="text-on-surface font-medium">{{ $s->baslik ?: $s->anahtar }}</p><p class="text-xs text-stone-grey">anahtar: {{ $s->anahtar }}</p></div>
                <span class="material-symbols-outlined text-stone-grey">chevron_right</span>
            </a>
        @endforeach
    </div>
@endsection
