@extends('layouts.panel')
@section('baslik', 'Raporlar')

@section('content')
    <x-panel.baslik baslik="Raporlar" aciklama="Teklif ve içerik istatistikleri." />

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-panel.card><p class="font-label-caps text-[10px] text-stone-grey uppercase">Toplam Talep</p><p class="text-3xl font-bold text-gold-light mt-2">{{ $toplamTalep }}</p></x-panel.card>
        <x-panel.card><p class="font-label-caps text-[10px] text-stone-grey uppercase">Bu Ay</p><p class="text-3xl font-bold text-gold-light mt-2">{{ $aylikTalep }}</p></x-panel.card>
        <x-panel.card><p class="font-label-caps text-[10px] text-stone-grey uppercase">Ürün</p><p class="text-3xl font-bold text-gold-light mt-2">{{ $urunSayisi }}</p></x-panel.card>
        <x-panel.card><p class="font-label-caps text-[10px] text-stone-grey uppercase">Proje</p><p class="text-3xl font-bold text-gold-light mt-2">{{ $projeSayisi }}</p></x-panel.card>
    </div>

    <x-panel.card baslik="Talep Durum Dağılımı">
        <div class="space-y-3">
            @foreach(\App\Models\Talep::DURUMLAR as $key => $etiket)
                @php($adet = $durumlar[$key] ?? 0)
                @php($yuzde = $toplamTalep > 0 ? round($adet / $toplamTalep * 100) : 0)
                <div>
                    <div class="flex justify-between text-sm mb-1"><span class="text-on-surface">{{ $etiket }}</span><span class="text-stone-grey">{{ $adet }}</span></div>
                    <div class="h-2 bg-surface-variant rounded-full overflow-hidden"><div class="h-full bg-gold-light rounded-full" style="width: {{ $yuzde }}%"></div></div>
                </div>
            @endforeach
        </div>
    </x-panel.card>
@endsection
