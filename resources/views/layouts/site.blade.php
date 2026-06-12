<!DOCTYPE html>
<html lang="tr" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ayar('site_basligi', 'Sekmen Zemin Tasarım'))</title>
    <meta name="description" content="@yield('meta_desc', ayar('slogan'))">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ ayar('site_basligi', 'Sekmen Zemin Tasarım') }}">
    <meta property="og:title" content="@yield('title', ayar('site_basligi'))">
    <meta property="og:description" content="@yield('meta_desc', ayar('slogan'))">
    <meta property="og:image" content="@yield('og_image', gorsel(null))">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Search Console doğrulama --}}
    @if($scMeta = optional($pazarlamaAyari)->search_console_meta)
        <meta name="google-site-verification" content="{{ $scMeta }}">
    @endif

    @php($favicon = ayar('favicon'))
    <link rel="icon" href="{{ $favicon ? gorsel($favicon) : asset('img/placeholder.svg') }}">

    {{-- Fontlar --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Hanken+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Yapısal veri --}}
    @include('partials.schema')
    @stack('schema')

    {{-- Pazarlama: <head> takip kodları --}}
    @include('partials.tracking-head')
    @stack('head')
</head>
<body class="bg-background text-on-background font-body-md antialiased selection:bg-gold-light selection:text-background overflow-x-hidden">

    @include('partials.tracking-body')

    @include('partials.header')

    <main id="icerik">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp')

    {{-- Event mapping (JS tarafına) --}}
    <script>
        window.SEKMEN_EVENTS = @json($pazarlamaAyari->aktifEventHaritasi());
    </script>

    @stack('scripts')
</body>
</html>
