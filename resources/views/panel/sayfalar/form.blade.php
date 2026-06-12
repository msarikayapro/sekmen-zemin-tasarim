@extends('layouts.panel')
@section('baslik', 'Sayfa Düzenle')

@section('content')
    <x-panel.baslik :baslik="($sayfa->baslik ?: $sayfa->anahtar) . ' Sayfası'" />
    <form method="POST" action="{{ route('panel.sayfalar.update', $sayfa) }}" class="max-w-3xl space-y-6">
        @csrf @method('PUT')
        <x-panel.card>
            <x-panel.input label="Başlık" name="baslik" :value="$sayfa->baslik" />
            @if($sayfa->anahtar !== 'home')
                <x-panel.textarea label="İçerik (HTML destekli)" name="icerik" :value="$sayfa->icerik" rows="14" />
            @endif
        </x-panel.card>

        @if($sayfa->anahtar === 'home')
            <x-panel.card baslik="Ana Sayfa Blokları">
                <x-panel.input label="'Neden Sekmen' Başlık" name="bloklar[neden_baslik]" :value="$sayfa->bloklar['neden_baslik'] ?? ''" />
                <x-panel.textarea label="'Neden Sekmen' Açıklama" name="bloklar[neden_aciklama]" :value="$sayfa->bloklar['neden_aciklama'] ?? ''" rows="2" />
                <x-panel.input label="SEO Blok Başlık" name="bloklar[seo_blok_baslik]" :value="$sayfa->bloklar['seo_blok_baslik'] ?? ''" />
                <x-panel.textarea label="SEO Blok İçerik (HTML)" name="bloklar[seo_blok_icerik]" :value="$sayfa->bloklar['seo_blok_icerik'] ?? ''" rows="6" />
            </x-panel.card>
        @endif
        @if($sayfa->anahtar === 'about')
            <x-panel.card baslik="Misyon / Vizyon">
                <x-panel.input label="Misyon" name="bloklar[misyon]" :value="$sayfa->bloklar['misyon'] ?? ''" />
                <x-panel.input label="Vizyon" name="bloklar[vizyon]" :value="$sayfa->bloklar['vizyon'] ?? ''" />
            </x-panel.card>
        @endif

        <x-panel.card baslik="SEO">
            <x-panel.input label="Meta Title" name="meta_title" :value="$sayfa->meta_title" />
            <x-panel.textarea label="Meta Description" name="meta_desc" :value="$sayfa->meta_desc" rows="2" />
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.sayfalar.index')" />
    </form>
@endsection
