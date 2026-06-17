<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('baslik', 'Yönetim Paneli') — Sekmen Zemin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Hanken+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen lg:flex">

    @php
        $admin = auth()->user()?->isAdmin();
        $yeniTalep = \App\Models\Talep::where('durum', 'yeni')->count();
        $nav = [
            ['panel.dashboard', 'home', 'Panel', false],
            ['panel.talepler.index', 'description', 'Teklif Talepleri', false, $yeniTalep],
            ['panel.urunler.index', 'category', 'Ürün Kataloğu', false],
            ['panel.kategoriler.index', 'sell', 'Kategoriler', false],
            ['panel.projeler.index', 'architecture', 'Projeler', false],
            ['panel.oncesi-sonrasi.index', 'compare', 'Öncesi / Sonrası', false],
            ['panel.hizmetler.index', 'handyman', 'Hizmetler', false],
            ['panel.yorumlar.index', 'reviews', 'Yorumlar', false],
            ['panel.sss.index', 'quiz', 'SSS', false],
            ['panel.bannerlar.index', 'view_carousel', 'Banner / Slider', false],
            ['panel.showcases.index', 'collections', 'Vitrin Yönetimi', false],
            ['panel.sayfalar.index', 'edit_note', 'İçerik Sayfaları', false],
            ['panel.blog.index', 'article', 'Blog', false],
            ['panel.seo-landing.index', 'travel_explore', 'SEO Landing', false],
            ['panel.yonlendirmeler.index', 'alt_route', '301 Yönlendirme', false],
            ['panel.ayarlar.index', 'settings', 'Genel Ayarlar', true],
            ['panel.pazarlama.index', 'campaign', 'Pazarlama & Takip', true],
            ['panel.kullanicilar.index', 'group', 'Kullanıcılar', true],
            ['panel.raporlar', 'monitoring', 'Raporlar', false],
        ];
    @endphp

    {{-- Masaüstü sidebar --}}
    <aside class="hidden lg:flex lg:flex-col w-72 shrink-0 bg-surface-container-low border-r border-surface-variant h-screen sticky top-0">
        <div class="px-6 py-5 border-b border-surface-variant">
            <a href="{{ route('panel.dashboard') }}" class="flex flex-col">
                <span class="font-headline-md text-xl font-bold text-gold-light uppercase tracking-wider">SEKMEN</span>
                <span class="font-label-caps text-[10px] text-stone-grey uppercase">Yönetim Paneli</span>
            </a>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @foreach($nav as $item)
                @php
                    $adminOnly = $item[3] ?? false;
                    $rota = $item[0]; $ikon = $item[1]; $etiket = $item[2]; $badge = $item[4] ?? 0;
                @endphp
                @continue($adminOnly && ! $admin)
                <a href="{{ route($rota) }}"
                   class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs(str_replace('.index','.*',$rota)) || request()->routeIs($rota) ? 'bg-gold-light/10 text-gold-light border border-gold-light/20' : 'text-on-surface-variant hover:bg-surface-variant' }}">
                    <span class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-xl">{{ $ikon }}</span>
                        <span class="text-sm font-medium">{{ $etiket }}</span>
                    </span>
                    @if($badge > 0)
                        <span class="bg-gold-light text-background text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center">{{ $badge }}</span>
                    @endif
                </a>
            @endforeach
        </nav>
        <div class="px-3 pt-3">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-gold-light/10 text-gold-light border border-gold-light/20 hover:bg-gold-light/20 transition-colors">
                <span class="material-symbols-outlined text-xl">open_in_new</span>
                <span class="text-sm font-medium">Siteyi Görüntüle</span>
            </a>
        </div>
        <div class="px-4 py-4 border-t border-surface-variant mt-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-full bg-surface-container-high border border-gold-light/30 flex items-center justify-center text-gold-light material-symbols-outlined">person</span>
                    <div class="min-w-0">
                        <p class="text-sm text-on-surface truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-stone-grey uppercase">{{ $admin ? 'Yönetici' : 'Editör' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('panel.logout') }}">@csrf
                    <button class="text-stone-grey hover:text-error p-1" title="Çıkış"><span class="material-symbols-outlined">logout</span></button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Ana içerik --}}
    <div class="flex-1 min-w-0 pb-24 lg:pb-0">
        {{-- Mobil üst bar --}}
        <header class="lg:hidden sticky top-0 z-50 bg-surface/90 backdrop-blur-md px-4 py-3 flex justify-between items-center border-b border-surface-variant">
            <div class="flex flex-col">
                <span class="font-headline-md text-lg font-bold text-gold-light uppercase tracking-wider">SEKMEN</span>
                <span class="font-label-caps text-[9px] text-stone-grey uppercase">Admin Panel</span>
            </div>
            <button data-menu-toggle class="text-on-surface p-1"><span class="material-symbols-outlined text-3xl">menu</span></button>
        </header>

        {{-- Mobil menü drawer --}}
        <div data-mobile-menu class="fixed inset-0 z-[200] bg-background translate-x-full transition-transform duration-300 lg:hidden flex flex-col">
            <div class="flex justify-between items-center px-4 py-4 border-b border-surface-variant">
                <span class="font-headline-md text-lg font-bold text-gold-light uppercase">Menü</span>
                <button data-menu-close class="text-on-surface p-1"><span class="material-symbols-outlined text-3xl">close</span></button>
            </div>
            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-1">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gold-light/10 text-gold-light border border-gold-light/20 mb-2">
                    <span class="material-symbols-outlined">open_in_new</span><span>Siteyi Görüntüle</span>
                </a>
                @foreach($nav as [$rota, $ikon, $etiket, $adminOnly])
                    @continue($adminOnly && ! $admin)
                    <a data-menu-close href="{{ route($rota) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-variant">
                        <span class="material-symbols-outlined">{{ $ikon }}</span><span>{{ $etiket }}</span>
                    </a>
                @endforeach
                <form method="POST" action="{{ route('panel.logout') }}" class="pt-2">@csrf
                    <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-error hover:bg-error/10"><span class="material-symbols-outlined">logout</span> Çıkış Yap</button>
                </form>
            </nav>
        </div>

        <main class="p-4 md:p-8 max-w-6xl mx-auto">
            @include('panel.partials.flash')
            @yield('content')
        </main>
    </div>

    {{-- Mobil alt navigasyon (app hissi) --}}
    <nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pt-2 pb-3 bg-surface/95 backdrop-blur-xl border-t border-surface-variant shadow-[0_-4px_20px_rgba(0,0,0,0.5)]">
        @php
            $bottom = [
                ['panel.dashboard', 'home', 'Panel'],
                ['panel.urunler.index', 'category', 'Ürünler'],
                ['panel.talepler.index', 'description', 'Teklif'],
                ['panel.projeler.index', 'architecture', 'Proje'],
                ['panel.sss.index', 'quiz', 'SSS'],
            ];
        @endphp
        @foreach($bottom as [$rota, $ikon, $etiket])
            <a href="{{ route($rota) }}" class="flex flex-col items-center justify-center gap-0.5 px-3 py-1 rounded-xl relative {{ request()->routeIs(str_replace('.index','.*',$rota)) ? 'text-gold-light' : 'text-stone-grey' }}">
                <span class="material-symbols-outlined">{{ $ikon }}</span>
                <span class="font-label-caps text-[9px]">{{ $etiket }}</span>
                @if($rota === 'panel.talepler.index' && $yeniTalep > 0)
                    <span class="absolute top-0 right-1 bg-error w-2 h-2 rounded-full"></span>
                @endif
            </a>
        @endforeach
    </nav>

    {{-- Form içindeki AJAX silme butonları (data-sil-url) — nested form veri-kaybı hatasını önler --}}
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('[data-sil-url]');
            if (! btn) return;
            e.preventDefault();
            if (! confirm(btn.dataset.silOnay || 'Silmek istediğinize emin misiniz?')) return;
            btn.disabled = true;
            try {
                const res = await fetch(btn.dataset.silUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                });
                if (! res.ok) throw new Error();
                (btn.closest('[data-sil-item]') || btn.closest('.group') || btn.parentElement).remove();
            } catch {
                btn.disabled = false;
                alert('Silme işlemi başarısız oldu. Lütfen tekrar deneyin.');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
