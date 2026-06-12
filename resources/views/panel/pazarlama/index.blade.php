@extends('layouts.panel')
@section('baslik', 'Pazarlama & Takip')

@section('content')
    <x-panel.baslik baslik="Pazarlama & Takip" aciklama="Meta Pixel, CAPI, GA4, GTM, Google Ads ve özel kod enjeksiyonu." />

    <form method="POST" action="{{ route('panel.pazarlama.update') }}" class="space-y-6">
        @csrf

        <x-panel.card baslik="Meta (Facebook) Pixel">
            <x-panel.input label="Pixel ID" name="meta_pixel_id" :value="$pz->meta_pixel_id" />
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="meta_pixel_aktif" value="1" @checked($pz->meta_pixel_aktif) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                <span class="text-sm text-on-surface">Pixel aktif (frontend'e inject et)</span>
            </label>
        </x-panel.card>

        <x-panel.card baslik="Conversions API (CAPI) — Server-side">
            <x-panel.input label="Access Token" name="capi_token" type="password" placeholder="{{ $pz->capi_token ? '•••••• (kayıtlı — değiştirmek için yenisini girin)' : '' }}" help="Boş bırakılırsa mevcut token korunur." />
            <div class="grid grid-cols-2 gap-4">
                <x-panel.input label="Test Event Code" name="capi_test_code" :value="$pz->capi_test_code" />
                <label class="flex items-center gap-3 cursor-pointer mt-6">
                    <input type="checkbox" name="capi_aktif" value="1" @checked($pz->capi_aktif) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    <span class="text-sm text-on-surface">CAPI aktif</span>
                </label>
            </div>
        </x-panel.card>

        <x-panel.card baslik="Event Mapping">
            <p class="text-xs text-stone-grey -mt-2">Her site aksiyonunun Meta event'ine eşlenmesi. Engagement event'leri (scroll, time) varsayılan pasiftir (quota koruması).</p>
            <div class="divide-y divide-surface-variant/60">
                @foreach($varsayilan as $key => $cfg)
                    @php($aktif = $eventler[$key]['active'] ?? $cfg['active'])
                    <label class="flex items-center justify-between py-3 cursor-pointer">
                        <div><p class="text-on-surface text-sm">{{ $key }}</p><p class="text-xs text-stone-grey">→ {{ $cfg['meta'] }}</p></div>
                        <input type="checkbox" name="event_{{ $key }}" value="1" @checked($aktif) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    </label>
                @endforeach
            </div>
        </x-panel.card>

        <x-panel.card baslik="Diğer Entegrasyonlar">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-panel.input label="GTM Container ID" name="gtm_id" :value="$pz->gtm_id" placeholder="GTM-XXXXXXX" />
                <x-panel.input label="GA4 Measurement ID" name="ga4_id" :value="$pz->ga4_id" placeholder="G-XXXXXXXXXX" />
                <x-panel.input label="Google Ads Conversion ID" name="google_ads_id" :value="$pz->google_ads_id" placeholder="AW-XXXXXXXXX" />
                <x-panel.input label="Google Ads Label" name="google_ads_label" :value="$pz->google_ads_label" />
            </div>
            <x-panel.input label="Search Console Doğrulama (meta content)" name="search_console_meta" :value="$pz->search_console_meta" />
        </x-panel.card>

        <x-panel.card baslik="Özel Kod Enjeksiyonu">
            <x-panel.textarea label="<head> Kodu" name="head_kod" :value="$pz->head_kod" rows="4" help="Analitik script, doğrulama meta, preconnect vb." />
            <x-panel.textarea label="<body> Kodu" name="body_kod" :value="$pz->body_kod" rows="4" help="Chat widget, GTM noscript, footer script vb." />
        </x-panel.card>

        <x-panel.kaydet-bar />
    </form>

    <x-panel.card baslik="CAPI Test Event" class="mt-6">
        <p class="text-sm text-stone-grey">Pixel ID ve CAPI token kaydettikten sonra Meta'ya örnek bir 'Lead' test eventi gönderin.</p>
        <form method="POST" action="{{ route('panel.pazarlama.test') }}">@csrf
            <button class="inline-flex items-center gap-2 bg-surface-variant text-on-surface px-5 py-2.5 rounded-lg text-sm font-bold uppercase hover:bg-surface-container-high"><span class="material-symbols-outlined text-lg">send</span> Test Event Gönder</button>
        </form>
    </x-panel.card>
@endsection
