@extends('layouts.panel')
@section('baslik', $banner->exists ? 'Banner Düzenle' : 'Yeni Banner')

@section('content')
    <x-panel.baslik :baslik="$banner->exists ? 'Banner Düzenle' : 'Yeni Banner'" />
    <form method="POST" action="{{ $banner->exists ? route('panel.bannerlar.update', $banner) : route('panel.bannerlar.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($banner->exists) @method('PUT') @endif
        <x-panel.card>
            <div class="space-y-1.5">
                <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Görsel @if(!$banner->exists)<span class="text-gold-light">*</span>@endif</label>
                @if($banner->gorsel)<img src="{{ gorsel($banner->gorsel) }}" class="w-full aspect-video object-cover rounded-lg mb-2" alt="">@endif
                <input type="file" name="gorsel" accept="image/*" @if(!$banner->exists) required @endif class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </div>
            <x-panel.input label="Başlık" name="baslik" :value="$banner->baslik" />
            <x-panel.textarea label="Alt Başlık" name="alt_baslik" :value="$banner->alt_baslik" rows="2" />
            <div class="grid grid-cols-2 gap-4">
                <x-panel.input label="Buton Yazısı" name="buton_yazi" :value="$banner->buton_yazi" />
                <x-panel.input label="Link" name="link" :value="$banner->link" />
                <x-panel.input label="Alt Metin (erişilebilirlik)" name="alt_metin" :value="$banner->alt_metin" />
                <x-panel.input label="Sıra" name="sira" type="number" :value="$banner->sira" />
            </div>
            <x-panel.select label="Durum" name="durum" :value="$banner->durum" :options="['yayin'=>'Yayında','gizli'=>'Gizli']" />
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.bannerlar.index')" />
    </form>
@endsection
