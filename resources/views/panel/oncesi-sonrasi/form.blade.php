@extends('layouts.panel')
@section('baslik', $kayit->exists ? 'Öncesi/Sonrası Düzenle' : 'Yeni Öncesi/Sonrası')

@section('content')
    <x-panel.baslik :baslik="$kayit->exists ? 'Düzenle' : 'Yeni Öncesi / Sonrası'" />
    <form method="POST" action="{{ $kayit->exists ? route('panel.oncesi-sonrasi.update', $kayit) : route('panel.oncesi-sonrasi.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($kayit->exists) @method('PUT') @endif
        <x-panel.card>
            <x-panel.input label="Başlık" name="baslik" :value="$kayit->baslik" />
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Öncesi Görsel @if(!$kayit->exists)<span class="text-gold-light">*</span>@endif</label>
                    @if($kayit->oncesi_gorsel)<img src="{{ gorsel($kayit->oncesi_gorsel) }}" class="w-full aspect-video object-cover rounded-lg mb-2" alt="">@endif
                    <input type="file" name="oncesi_gorsel" accept="image/*" @if(!$kayit->exists) required @endif class="block w-full text-sm text-stone-grey file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Sonrası Görsel @if(!$kayit->exists)<span class="text-gold-light">*</span>@endif</label>
                    @if($kayit->sonrasi_gorsel)<img src="{{ gorsel($kayit->sonrasi_gorsel) }}" class="w-full aspect-video object-cover rounded-lg mb-2" alt="">@endif
                    <input type="file" name="sonrasi_gorsel" accept="image/*" @if(!$kayit->exists) required @endif class="block w-full text-sm text-stone-grey file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <x-panel.select label="İlişkili Proje" name="proje_id" :value="$kayit->proje_id" :options="['' => 'Yok'] + $projeler->pluck('baslik','id')->toArray()" />
                <x-panel.select label="Durum" name="durum" :value="$kayit->durum" :options="['yayin'=>'Yayında','gizli'=>'Gizli']" />
                <x-panel.input label="Sıra" name="sira" type="number" :value="$kayit->sira" />
            </div>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.oncesi-sonrasi.index')" />
    </form>
@endsection
