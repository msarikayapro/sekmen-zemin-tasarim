@php
    $navKategoriler = $footerKategoriler ?? \App\Models\Kategori::orderBy('sira')->get();
@endphp
<header data-header class="sticky top-0 z-[100] w-full glass-nav border-b border-surface-variant transition-all duration-300">
    <nav class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            @if($logo = ayar('logo'))
                <img src="{{ gorsel($logo) }}" alt="{{ ayar('site_basligi') }}" class="h-9 w-auto">
            @else
                <span class="font-headline-md text-xl md:text-headline-md font-bold text-on-surface uppercase tracking-wider">
                    Sekmen <span class="text-gold-light">Zemin</span>
                </span>
            @endif
        </a>

        {{-- Masaüstü menü --}}
        <div class="hidden lg:flex items-center gap-8 font-label-caps text-label-caps">
            <a href="{{ route('home') }}" class="@if(request()->routeIs('home')) text-gold-light border-b-2 border-gold-light pb-1 @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase">Ana Sayfa</a>
            <a href="{{ route('hakkimizda') }}" class="@if(request()->routeIs('hakkimizda')) text-gold-light @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase">Hakkımızda</a>

            {{-- Ürünler dropdown --}}
            <div class="relative group">
                <a href="{{ route('urunler.index') }}" class="@if(request()->routeIs('urunler.*')) text-gold-light @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase inline-flex items-center gap-1">
                    Ürünler <span class="material-symbols-outlined text-base">expand_more</span>
                </a>
                <div class="absolute left-0 top-full pt-3 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <div class="bg-surface-container-high border border-surface-variant rounded-xl shadow-2xl p-2">
                        @foreach($navKategoriler as $kat)
                            <a href="{{ route('urunler.index', ['kategori' => $kat->slug]) }}" class="block px-4 py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-variant hover:text-gold-light transition-colors normal-case tracking-normal text-sm">{{ $kat->ad }}</a>
                        @endforeach
                        <a href="{{ route('urunler.index') }}" class="block px-4 py-2.5 rounded-lg text-gold-light hover:bg-surface-variant transition-colors normal-case tracking-normal text-sm font-bold">Tüm Ürünler →</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('hizmetler.index') }}" class="@if(request()->routeIs('hizmetler.*')) text-gold-light @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase">Hizmetler</a>
            <a href="{{ route('projeler.index') }}" class="@if(request()->routeIs('projeler.*')) text-gold-light @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase">Projeler</a>
            <a href="{{ route('iletisim') }}" class="@if(request()->routeIs('iletisim')) text-gold-light @else text-on-surface-variant hover:text-gold-light @endif transition-colors duration-300 uppercase">İletişim</a>
        </div>

        {{-- Sağ aksiyon --}}
        <div class="flex items-center gap-3">
            <a href="{{ tel_link(ayar('telefon')) }}" data-track="phone_click" class="hidden xl:block text-stone-grey hover:text-gold-light font-label-caps text-[11px] transition-colors">{{ ayar('telefon') }}</a>
            <a href="{{ route('iletisim') }}" class="hidden sm:inline-block bg-gold-light text-background px-6 py-2.5 rounded-lg font-label-caps text-label-caps font-bold hover:bg-gold-dark transition-all active:scale-95 uppercase">Teklif Al</a>
            <button data-menu-toggle class="lg:hidden text-on-surface p-1" aria-label="Menü">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </div>
    </nav>
</header>

{{-- Mobil tam ekran menü --}}
<div data-mobile-menu class="fixed inset-0 z-[200] bg-background translate-x-full transition-transform duration-300 lg:hidden flex flex-col">
    <div class="flex justify-between items-center px-margin-mobile py-4 border-b border-surface-variant">
        <span class="font-headline-md text-xl font-bold text-on-surface uppercase tracking-wider">Sekmen <span class="text-gold-light">Zemin</span></span>
        <button data-menu-close class="text-on-surface p-1" aria-label="Kapat"><span class="material-symbols-outlined text-3xl">close</span></button>
    </div>
    <nav class="flex-1 overflow-y-auto px-margin-mobile py-6 flex flex-col gap-1 font-headline-md">
        <a data-menu-close href="{{ route('home') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">Ana Sayfa</a>
        <a data-menu-close href="{{ route('hakkimizda') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">Hakkımızda</a>
        <a data-menu-close href="{{ route('urunler.index') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">Ürünler</a>
        <a data-menu-close href="{{ route('hizmetler.index') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">Hizmetler</a>
        <a data-menu-close href="{{ route('projeler.index') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">Projeler</a>
        <a data-menu-close href="{{ route('iletisim') }}" class="py-3 text-lg text-on-surface border-b border-surface-variant/40">İletişim</a>
    </nav>
    <div class="px-margin-mobile py-6 border-t border-surface-variant flex gap-3">
        <a href="{{ route('iletisim') }}" class="flex-1 text-center bg-gold-light text-background px-4 py-3 rounded-lg font-label-caps font-bold uppercase">Teklif Al</a>
        <a href="{{ whatsapp_link() }}" data-track="whatsapp_click" class="flex-1 text-center bg-[#25D366] text-white px-4 py-3 rounded-lg font-label-caps font-bold uppercase">WhatsApp</a>
    </div>
</div>
