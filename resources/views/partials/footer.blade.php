<footer class="bg-surface-container-lowest border-t border-surface-variant/30 pt-16 pb-8">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        {{-- Sütun 1: Marka --}}
        <div class="space-y-6">
            <div class="font-headline-md text-headline-md font-bold text-on-surface uppercase tracking-wider">
                Sekmen <span class="text-gold-light">Zemin</span>
            </div>
            <p class="text-stone-grey text-sm leading-relaxed">{{ ayar('footer_aciklama') }}</p>
            <div class="flex gap-3">
                @if($ig = ayar('sosyal_instagram'))
                    <a href="{{ $ig }}" target="_blank" rel="noopener" aria-label="Instagram" class="w-10 h-10 rounded-full border border-surface-variant flex items-center justify-center hover:bg-gold-light hover:border-gold-light hover:text-background text-cream-white transition-all">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85C2.38 3.93 3.9 2.38 7.15 2.23 8.42 2.18 8.8 2.16 12 2.16zm0 3.68a6.16 6.16 0 100 12.32 6.16 6.16 0 000-12.32zm0 10.16a4 4 0 110-8 4 4 0 010 8zm6.4-11.85a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z"/></svg>
                    </a>
                @endif
                @if($fb = ayar('sosyal_facebook'))
                    <a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook" class="w-10 h-10 rounded-full border border-surface-variant flex items-center justify-center hover:bg-gold-light hover:border-gold-light hover:text-background text-cream-white transition-all">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.64L18 8h-4V6.33c0-.95.19-1.33 1.11-1.33H18V0h-3.81C10.59 0 9 1.58 9 4.62V8z"/></svg>
                    </a>
                @endif
                @if($yt = ayar('sosyal_youtube'))
                    <a href="{{ $yt }}" target="_blank" rel="noopener" aria-label="YouTube" class="w-10 h-10 rounded-full border border-surface-variant flex items-center justify-center hover:bg-gold-light hover:border-gold-light hover:text-background text-cream-white transition-all">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8zM9.5 15.5v-7l6.5 3.5-6.5 3.5z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Sütun 2: Hızlı linkler --}}
        <div class="space-y-5">
            <h4 class="text-gold-light font-headline-md font-bold uppercase">Hızlı Bağlantılar</h4>
            <ul class="space-y-3 text-stone-grey text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-gold-light transition-colors">Ana Sayfa</a></li>
                <li><a href="{{ route('hakkimizda') }}" class="hover:text-gold-light transition-colors">Hakkımızda</a></li>
                <li><a href="{{ route('hizmetler.index') }}" class="hover:text-gold-light transition-colors">Hizmetlerimiz</a></li>
                <li><a href="{{ route('urunler.index') }}" class="hover:text-gold-light transition-colors">Ürün Kataloğu</a></li>
                <li><a href="{{ route('projeler.index') }}" class="hover:text-gold-light transition-colors">Tamamlanan Projeler</a></li>
                <li><a href="{{ route('iletisim') }}" class="hover:text-gold-light transition-colors">İletişim</a></li>
            </ul>
        </div>

        {{-- Sütun 3: Ürün kategorileri --}}
        <div class="space-y-5">
            <h4 class="text-gold-light font-headline-md font-bold uppercase">Ürün Grupları</h4>
            <ul class="space-y-3 text-stone-grey text-sm">
                @foreach($footerKategoriler as $kat)
                    <li><a href="{{ route('urunler.index', ['kategori' => $kat->slug]) }}" class="hover:text-gold-light transition-colors">{{ $kat->ad }}</a></li>
                @endforeach
                <li><a href="{{ route('kvkk') }}" class="hover:text-gold-light transition-colors">KVKK Aydınlatma Metni</a></li>
                <li><a href="{{ route('cerez') }}" class="hover:text-gold-light transition-colors">Çerez Politikası</a></li>
            </ul>
        </div>

        {{-- Sütun 4: İletişim --}}
        <div class="space-y-5">
            <h4 class="text-gold-light font-headline-md font-bold uppercase">İletişim</h4>
            <div class="space-y-4 text-stone-grey text-sm">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gold-light text-xl">location_on</span>
                    <p>{{ ayar('adres') }}</p>
                </div>
                <a href="{{ tel_link(ayar('telefon')) }}" data-track="phone_click" class="flex items-start gap-3 hover:text-gold-light transition-colors">
                    <span class="material-symbols-outlined text-gold-light text-xl">call</span>
                    <span>{{ ayar('telefon') }}</span>
                </a>
                <a href="mailto:{{ ayar('email') }}" data-track="email_click" class="flex items-start gap-3 hover:text-gold-light transition-colors">
                    <span class="material-symbols-outlined text-gold-light text-xl">mail</span>
                    <span>{{ ayar('email') }}</span>
                </a>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gold-light text-xl">schedule</span>
                    <p>{{ ayar('calisma_saatleri') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-14 pt-8 border-t border-surface-variant/30 flex flex-col md:flex-row justify-between items-center gap-3 text-stone-grey text-xs">
        <p>© {{ date('Y') }} {{ ayar('site_basligi', 'Sekmen Zemin Tasarım') }}. Tüm hakları saklıdır.</p>
        <p>ReklamPro tarafından geliştirilmiştir.</p>
    </div>
</footer>
