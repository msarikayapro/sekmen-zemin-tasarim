@extends('layouts.panel')
@section('baslik', $hizmet->exists ? 'Hizmet Düzenle' : 'Yeni Hizmet')

@section('content')
    <x-panel.baslik :baslik="$hizmet->exists ? $hizmet->ad : 'Yeni Hizmet'" />
    <form method="POST" action="{{ $hizmet->exists ? route('panel.hizmetler.update', $hizmet) : route('panel.hizmetler.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($hizmet->exists) @method('PUT') @endif
        <x-panel.card>
            <x-panel.input label="Hizmet Adı" name="ad" :value="$hizmet->ad" required />
            <x-panel.input label="İkon (Material Symbols adı)" name="ikon" :value="$hizmet->ikon" help="Örn: architecture, park, foundation, handyman. fonts.google.com/icons" />
            <x-panel.textarea label="Açıklama" name="aciklama" :value="$hizmet->aciklama" rows="4" />
            <div class="grid grid-cols-2 gap-4">
                <x-panel.select label="Durum" name="durum" :value="$hizmet->durum" :options="['yayin'=>'Yayında','taslak'=>'Taslak']" />
                <x-panel.input label="Sıra" name="sira" type="number" :value="$hizmet->sira" />
            </div>
            <div class="space-y-1.5">
                <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Görsel (opsiyonel)</label>
                @if($hizmet->gorsel)<img src="{{ gorsel($hizmet->gorsel) }}" class="w-24 h-16 rounded-lg object-cover mb-2" alt="">@endif
                <input type="file" name="gorsel" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </div>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.hizmetler.index')" />
    </form>
@endsection
