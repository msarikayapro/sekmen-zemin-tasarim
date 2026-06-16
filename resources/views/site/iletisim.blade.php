@extends('layouts.site')

@section('title', 'İletişim & Teklif Al | Sekmen Zemin Tasarım')
@section('meta_desc', 'Ücretsiz keşif ve teklif için bize ulaşın. Konya merkezli parke taşı uygulama ve peyzaj firması.')

@section('content')
    <section class="pt-16 pb-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <nav class="flex gap-2 text-stone-grey font-label-caps text-[10px] uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold-light">Ana Sayfa</a><span>/</span><span class="text-on-surface">İletişim</span>
        </nav>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-cream-white uppercase tracking-tight">İletişim & Teklif Al</h1>
        <p class="text-stone-grey mt-3 max-w-2xl">Projeniz için ücretsiz keşif ve teklif alın. Formu doldurun, ekibimiz en kısa sürede size dönsün.</p>
    </section>

    <section id="teklif" class="pb-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-5 gap-gutter">
        {{-- Form --}}
        <div class="lg:col-span-3">
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl p-6 md:p-8">
                @if(session('basari'))
                    <div class="mb-6 flex items-start gap-3 bg-success/10 border border-success/30 text-success rounded-xl px-4 py-4">
                        <span class="material-symbols-outlined">check_circle</span>
                        <div><p class="font-bold">Teşekkürler!</p><p class="text-sm">{{ session('basari') }}</p></div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 bg-error/10 border border-error/30 text-error rounded-xl px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $h)<li>{{ $h }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teklif.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="kaynak" value="iletisim_formu">
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">Ad Soyad <span class="text-gold-light">*</span></label>
                            <input name="ad" required value="{{ old('ad') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                        </div>
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">Telefon <span class="text-gold-light">*</span></label>
                            <input name="telefon" type="tel" required value="{{ old('telefon') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                        </div>
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">E-posta</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                        </div>
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">İl / İlçe</label>
                            <input name="il_ilce" value="{{ old('il_ilce') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                        </div>
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">İlgilenilen Ürün</label>
                            <select name="urun_id" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                                <option value="">Seçiniz (opsiyonel)</option>
                                @foreach($urunler as $u)
                                    <option value="{{ $u->id }}" @selected((string)old('urun_id', $seciliUrun) === (string)$u->id)>{{ $u->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="font-label-caps text-[11px] text-stone-grey uppercase">Yaklaşık Alan (m²)</label>
                            <input name="m2" value="{{ old('m2') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="font-label-caps text-[11px] text-stone-grey uppercase">Proje Açıklaması / Mesaj</label>
                        <textarea name="mesaj" rows="4" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none">{{ old('mesaj') }}</textarea>
                    </div>

                    <label class="flex items-start gap-3 text-sm text-stone-grey cursor-pointer">
                        <input type="checkbox" name="kvkk_onay" value="1" required class="mt-1 rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                        <span><a href="{{ route('kvkk') }}" target="_blank" class="text-gold-light underline">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin işlenmesini onaylıyorum. <span class="text-gold-light">*</span></span>
                    </label>

                    <button type="submit" data-track="lead_form_submit" class="btn-sweep w-full bg-gold-light text-background font-bold py-4 rounded-lg uppercase tracking-widest hover:bg-gold-dark transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span> Teklif Talebini Gönder
                    </button>
                </form>
            </div>
        </div>

        {{-- İletişim bilgileri --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-surface-container-low border border-surface-variant rounded-2xl p-6 space-y-5">
                <a href="{{ tel_link(ayar('telefon')) }}" data-track="phone_click" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 shrink-0 rounded-full bg-gold-light/10 text-gold-light flex items-center justify-center material-symbols-outlined">call</span>
                    <div><p class="text-[10px] uppercase text-stone-grey">Telefon</p><p class="text-on-surface group-hover:text-gold-light transition-colors">{{ ayar('telefon') }}</p></div>
                </a>
                <a href="{{ whatsapp_link() }}" data-track="whatsapp_click" target="_blank" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 shrink-0 rounded-full bg-[#25D366]/15 text-[#25D366] flex items-center justify-center material-symbols-outlined">chat</span>
                    <div><p class="text-[10px] uppercase text-stone-grey">WhatsApp</p><p class="text-on-surface group-hover:text-gold-light transition-colors">Hemen Yazın</p></div>
                </a>
                <a href="mailto:{{ ayar('email') }}" data-track="email_click" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 shrink-0 rounded-full bg-gold-light/10 text-gold-light flex items-center justify-center material-symbols-outlined">mail</span>
                    <div><p class="text-[10px] uppercase text-stone-grey">E-posta</p><p class="text-on-surface group-hover:text-gold-light transition-colors break-all">{{ ayar('email') }}</p></div>
                </a>
                <div class="flex items-start gap-4">
                    <span class="w-11 h-11 rounded-full bg-gold-light/10 text-gold-light flex items-center justify-center material-symbols-outlined shrink-0">location_on</span>
                    <div><p class="text-[10px] uppercase text-stone-grey">Adres</p><p class="text-on-surface text-sm">{{ ayar('adres') }}</p></div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="w-11 h-11 rounded-full bg-gold-light/10 text-gold-light flex items-center justify-center material-symbols-outlined shrink-0">schedule</span>
                    <div><p class="text-[10px] uppercase text-stone-grey">Çalışma Saatleri</p><p class="text-on-surface text-sm">{{ ayar('calisma_saatleri') }}</p></div>
                </div>
            </div>

            @if($embed = ayar('harita_embed'))
                <div class="rounded-2xl overflow-hidden border border-surface-variant aspect-square">
                    <iframe src="{{ $embed }}" class="w-full h-full" style="filter:grayscale(0.3) invert(0.92) hue-rotate(180deg)" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif
        </div>
    </section>

    <x-sss-bolum :ssler="$ssler" />
@endsection
