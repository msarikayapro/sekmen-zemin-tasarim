@extends('layouts.panel')
@section('baslik', $yorum->exists ? 'Yorum Düzenle' : 'Yeni Yorum')

@section('content')
    <x-panel.baslik :baslik="$yorum->exists ? 'Yorum Düzenle' : 'Yeni Yorum'" />
    <form method="POST" action="{{ $yorum->exists ? route('panel.yorumlar.update', $yorum) : route('panel.yorumlar.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($yorum->exists) @method('PUT') @endif
        <x-panel.card>
            <div class="grid grid-cols-2 gap-4">
                <x-panel.input label="Ad Soyad" name="ad" :value="$yorum->ad" required />
                <x-panel.input label="Ünvan" name="unvan" :value="$yorum->unvan" help="Villa Sahibi, Mimar, Müteahhit..." />
            </div>
            <x-panel.textarea label="Yorum İçeriği" name="icerik" :value="$yorum->icerik" rows="4" required />
            <div class="grid grid-cols-3 gap-4">
                <x-panel.select label="Puan" name="puan" :value="$yorum->puan ?? 5" :options="[5=>'5 Yıldız',4=>'4 Yıldız',3=>'3 Yıldız',2=>'2 Yıldız',1=>'1 Yıldız']" />
                <x-panel.select label="Durum" name="durum" :value="$yorum->durum" :options="['yayin'=>'Yayında','gizli'=>'Gizli']" />
                <x-panel.input label="Sıra" name="sira" type="number" :value="$yorum->sira" />
            </div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="one_cikan" value="1" @checked($yorum->one_cikan) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                <span class="text-sm text-on-surface">Öne çıkar</span>
            </label>
            <div class="space-y-1.5">
                <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Fotoğraf (opsiyonel)</label>
                @if($yorum->gorsel)<img src="{{ gorsel($yorum->gorsel) }}" class="w-16 h-16 rounded-full object-cover mb-2" alt="">@endif
                <input type="file" name="gorsel" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </div>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.yorumlar.index')" />
    </form>
@endsection
