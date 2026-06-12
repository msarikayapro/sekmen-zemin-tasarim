@extends('layouts.panel')
@section('baslik', 'Talep Detayı')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('panel.talepler.index') }}" class="text-stone-grey hover:text-on-surface"><span class="material-symbols-outlined">arrow_back</span></a>
        <h1 class="font-headline-md text-2xl text-cream-white">{{ $talep->ad }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-panel.card baslik="Talep Bilgileri">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    @php($alanlar = [
                        'Telefon' => $talep->telefon, 'E-posta' => $talep->email, 'İl/İlçe' => $talep->il_ilce,
                        'İlgilenilen' => $talep->ilgi_alani ?: $talep->urun?->ad, 'Yaklaşık Alan' => $talep->m2 ? $talep->m2.' m²' : null,
                        'Kaynak' => $talep->kaynak, 'Tarih' => $talep->created_at->format('d.m.Y H:i'),
                    ])
                    @foreach($alanlar as $etiket => $deger)
                        @if($deger)
                        <div><dt class="text-[10px] uppercase text-stone-grey">{{ $etiket }}</dt><dd class="text-on-surface mt-0.5">{{ $deger }}</dd></div>
                        @endif
                    @endforeach
                </dl>
                @if($talep->mesaj)
                    <div class="pt-4 border-t border-surface-variant/60"><dt class="text-[10px] uppercase text-stone-grey mb-1">Mesaj</dt><p class="text-on-surface text-sm">{{ $talep->mesaj }}</p></div>
                @endif
            </x-panel.card>

            <div class="flex flex-wrap gap-3">
                <a href="{{ tel_link($talep->telefon) }}" class="inline-flex items-center gap-2 bg-gold-light text-background px-5 py-3 rounded-lg font-bold text-sm uppercase"><span class="material-symbols-outlined">call</span> Ara</a>
                <a href="https://wa.me/{{ preg_replace('/\D+/','',$talep->telefon) }}" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white px-5 py-3 rounded-lg font-bold text-sm uppercase"><span class="material-symbols-outlined">chat</span> WhatsApp</a>
                @if($talep->email)<a href="mailto:{{ $talep->email }}" class="inline-flex items-center gap-2 bg-surface-variant text-on-surface px-5 py-3 rounded-lg font-bold text-sm uppercase"><span class="material-symbols-outlined">mail</span> E-posta</a>@endif
            </div>
        </div>

        <div class="space-y-6">
            <x-panel.card baslik="Durum">
                <form method="POST" action="{{ route('panel.talepler.durum', $talep) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <x-panel.select name="durum" :value="$talep->durum" :options="$durumlar" />
                    <button class="w-full bg-gold-light text-background font-bold py-2.5 rounded-lg text-sm uppercase">Güncelle</button>
                </form>
            </x-panel.card>
            <x-panel.sil-btn :action="route('panel.talepler.destroy', $talep)" onay="Bu talebi kalıcı olarak silmek istiyor musunuz?" class="!text-error border border-error/30 w-full !flex items-center justify-center gap-2 py-2.5" />
        </div>
    </div>
@endsection
