@extends('layouts.panel')
@section('baslik', $kategori->exists ? 'Kategori Düzenle' : 'Yeni Kategori')

@section('content')
    <x-panel.baslik :baslik="$kategori->exists ? $kategori->ad : 'Yeni Kategori'" />
    <form method="POST" action="{{ $kategori->exists ? route('panel.kategoriler.update', $kategori) : route('panel.kategoriler.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($kategori->exists) @method('PUT') @endif
        <x-panel.card>
            <x-panel.input label="Ad" name="ad" :value="$kategori->ad" required />
            <x-panel.input label="Slug" name="slug" :value="$kategori->slug" help="Boş bırakılırsa otomatik." />
            <x-panel.textarea label="SEO Açıklaması" name="aciklama_seo" :value="$kategori->aciklama_seo" rows="3" />
            <x-panel.input label="Sıra" name="sira" type="number" :value="$kategori->sira" />
            <div class="space-y-1.5">
                <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Görsel / İkon</label>
                @if($kategori->gorsel)<img src="{{ gorsel($kategori->gorsel) }}" class="w-20 h-20 rounded-lg object-cover mb-2" alt="">@endif
                <input type="file" name="gorsel" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </div>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.kategoriler.index')" />
    </form>
@endsection
