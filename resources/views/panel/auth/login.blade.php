<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Giriş — Sekmen Zemin Yönetim Paneli</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Hanken+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface flex items-center justify-center min-h-screen pavement-pattern p-4">
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[600px] h-[600px] bg-gold-dark/5 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-gold-dark/5 blur-[120px] rounded-full"></div>
    </div>

    <main class="relative z-10 w-full max-w-[440px]">
        <div class="glass-card rounded-2xl p-8 md:p-10" style="box-shadow:0 0 32px rgba(182,134,62,0.08)">
            <div class="mb-8 text-center">
                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center rounded-full bg-primary-container border border-gold-dark/30">
                    <span class="material-symbols-outlined text-tertiary text-4xl">architecture</span>
                </div>
                <h1 class="font-headline-md text-headline-md text-tertiary tracking-tight mb-1">Sekmen Zemin</h1>
                <p class="font-label-caps text-label-caps text-stone-grey uppercase">Yönetim Paneli</p>
            </div>

            @include('panel.partials.flash')

            <form method="POST" action="{{ route('panel.login.post') }}" class="space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label for="email" class="font-label-caps text-[11px] text-stone-grey uppercase">E-posta</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-grey text-xl">mail</span>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                               placeholder="admin@sekmenzemintasarim.com"
                               class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="font-label-caps text-[11px] text-stone-grey uppercase">Şifre</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-grey text-xl">lock</span>
                        <input id="password" name="password" type="password" required placeholder="••••••••"
                               class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg py-3.5 pl-12 pr-12 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none transition-all">
                        <button type="button" data-pw-toggle="password" class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-grey hover:text-tertiary transition-colors">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </button>
                    </div>
                </div>

                <label class="flex items-center gap-2 cursor-pointer text-sm text-stone-grey">
                    <input type="checkbox" name="remember" value="1" class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    Beni Hatırla
                </label>

                <button type="submit" class="btn-sweep w-full bg-gold-dark hover:bg-gold-light text-primary-container font-bold py-4 rounded-lg shadow-lg shadow-gold-dark/20 uppercase tracking-widest transition-colors">
                    Giriş Yap
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-outline-variant/30 text-center">
                <p class="font-label-caps text-[10px] text-stone-grey/70">© {{ date('Y') }} Sekmen Zemin Tasarım</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-center gap-2 opacity-50">
            <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
            <span class="font-label-caps text-[10px] text-stone-grey uppercase tracking-tighter">Sistem Durumu: Güvenli</span>
        </div>
    </main>
</body>
</html>
