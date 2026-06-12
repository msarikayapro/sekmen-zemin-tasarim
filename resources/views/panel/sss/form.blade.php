@extends('layouts.panel')
@section('baslik', $sss->exists ? 'Soru Düzenle' : 'Yeni Soru')

@section('content')
    <x-panel.baslik :baslik="$sss->exists ? 'Soru Düzenle' : 'Yeni Soru-Cevap'" />
    <form method="POST" action="{{ $sss->exists ? route('panel.sss.update', $sss) : route('panel.sss.store') }}" class="max-w-2xl space-y-6">
        @csrf @if($sss->exists) @method('PUT') @endif
        <x-panel.card>
            <x-panel.input label="Soru" name="soru" :value="$sss->soru" required />
            <x-panel.textarea label="Cevap" name="cevap" :value="$sss->cevap" rows="4" required />
            <div class="grid grid-cols-3 gap-4">
                <x-panel.select label="Kategori" name="kategori" :value="$sss->kategori" :options="array_combine(\App\Models\Sss::KATEGORILER, \App\Models\Sss::KATEGORILER)" />
                <x-panel.select label="Durum" name="durum" :value="$sss->durum" :options="['yayin'=>'Yayında','gizli'=>'Gizli']" />
                <x-panel.input label="Sıra" name="sira" type="number" :value="$sss->sira" />
            </div>
        </x-panel.card>
        <x-panel.card baslik="Görüneceği Sayfalar">
            <p class="text-xs text-stone-grey -mt-2">Hiçbiri seçilmezse <span class="text-gold-light">tüm sayfalarda</span> görünür. Seçilirse yalnızca o sayfalarda görünür ve sadece görünen sorular FAQ schema'ya dahil edilir.</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @foreach(\App\Models\Sss::SAYFALAR as $anahtar => $etiket)
                    <label class="flex items-center gap-2 cursor-pointer bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2">
                        <input type="checkbox" name="sayfalar[]" value="{{ $anahtar }}" @checked(in_array($anahtar, old('sayfalar', $seciliSayfalar))) class="rounded border-outline-variant bg-surface-container text-gold-dark focus:ring-gold-light">
                        <span class="text-xs text-on-surface">{{ $etiket }}</span>
                    </label>
                @endforeach
            </div>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.sss.index')" />
    </form>
@endsection
