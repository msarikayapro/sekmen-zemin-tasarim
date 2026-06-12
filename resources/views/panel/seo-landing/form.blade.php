@extends('layouts.panel')
@section('baslik', $sayfa->exists ? 'Landing Düzenle' : 'Yeni Landing')

@section('content')
    <x-panel.baslik :baslik="$sayfa->exists ? 'Landing Düzenle' : 'Yeni SEO Landing'" />
    <form method="POST" action="{{ $sayfa->exists ? route('panel.seo-landing.update', $sayfa) : route('panel.seo-landing.store') }}" class="max-w-3xl space-y-6">
        @csrf @if($sayfa->exists) @method('PUT') @endif
        <x-panel.card>
            <x-panel.input label="H1 Başlık" name="baslik_h1" :value="$sayfa->baslik_h1" required />
            <div class="grid grid-cols-2 gap-4">
                <x-panel.input label="Şehir" name="sehir" :value="$sayfa->sehir" />
                <x-panel.input label="Ürün Tipi" name="urun_tipi" :value="$sayfa->urun_tipi" />
            </div>
            <x-panel.input label="Slug (URL)" name="slug" :value="$sayfa->slug" help="Boş bırakılırsa şehir+tipten otomatik. Örn: konya-kilit-tasi" />
            <x-panel.textarea label="İçerik (HTML, uzun özgün metin)" name="icerik" :value="$sayfa->icerik" rows="12" />
            <x-panel.select label="Durum" name="durum" :value="$sayfa->durum" :options="['yayin'=>'Yayında','taslak'=>'Taslak']" />
        </x-panel.card>
        <x-panel.card baslik="SEO (boş bırakılırsa otomatik üretilir)">
            <x-panel.input label="Meta Title" name="meta_title" :value="$sayfa->meta_title" />
            <x-panel.textarea label="Meta Description" name="meta_desc" :value="$sayfa->meta_desc" rows="2" />
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.seo-landing.index')" />
    </form>
@endsection
