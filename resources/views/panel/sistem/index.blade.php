@extends('layouts.panel')
@section('baslik', 'Sistem / Bakım')

@section('content')
    <x-panel.baslik baslik="Sistem / Bakım" aciklama="SSH'sız web tabanlı bakım (Deploy Anayasası §5). Yalnızca süper-admin." />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-panel.card baslik="Veritabanı Güncelleme">
            <p class="text-sm text-stone-grey">Bekleyen migration'ları çalıştırır (<code class="text-gold-light">migrate --force</code>). Deploy sonrası kullanın.</p>
            <form method="POST" action="{{ route('panel.sistem.migrate') }}" onsubmit="return confirm('Migration çalıştırılsın mı?')">@csrf
                <button class="inline-flex items-center gap-2 bg-gold-light text-background px-5 py-3 rounded-lg font-bold text-sm uppercase hover:bg-gold-dark"><span class="material-symbols-outlined">database</span> Migrate Çalıştır</button>
            </form>
        </x-panel.card>

        <x-panel.card baslik="Görsel Bağı (Storage Link)">
            <p class="text-sm text-stone-grey"><code class="text-gold-light">public/storage</code> sembolik bağını oluşturur. Panelden yüklenen görseller görünmüyorsa (404) bunu çalıştırın.</p>
            <form method="POST" action="{{ route('panel.sistem.storage-link') }}">@csrf
                <button class="inline-flex items-center gap-2 bg-gold-light text-background px-5 py-3 rounded-lg font-bold text-sm uppercase hover:bg-gold-dark"><span class="material-symbols-outlined">link</span> Storage Link Oluştur</button>
            </form>
        </x-panel.card>

        <x-panel.card baslik="Önbellek Temizleme">
            <p class="text-sm text-stone-grey">Tüm Laravel önbelleklerini temizler (config, route, view, cache + bootstrap/cache).</p>
            <form method="POST" action="{{ route('panel.sistem.cache') }}">@csrf
                <button class="inline-flex items-center gap-2 bg-surface-variant text-on-surface px-5 py-3 rounded-lg font-bold text-sm uppercase hover:bg-surface-container-high"><span class="material-symbols-outlined">cleaning_services</span> Önbelleği Temizle</button>
            </form>
        </x-panel.card>
    </div>

    <x-panel.card baslik="Sistem Bilgisi" class="mt-6">
        <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div><dt class="text-[10px] uppercase text-stone-grey">PHP</dt><dd class="text-on-surface">{{ PHP_VERSION }}</dd></div>
            <div><dt class="text-[10px] uppercase text-stone-grey">Laravel</dt><dd class="text-on-surface">{{ app()->version() }}</dd></div>
            <div><dt class="text-[10px] uppercase text-stone-grey">Ortam</dt><dd class="text-on-surface">{{ app()->environment() }}</dd></div>
            <div><dt class="text-[10px] uppercase text-stone-grey">Debug</dt><dd class="text-on-surface">{{ config('app.debug') ? 'açık' : 'kapalı' }}</dd></div>
        </dl>
    </x-panel.card>
@endsection
