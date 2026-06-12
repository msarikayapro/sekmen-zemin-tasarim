{{-- CTA bandı + gömülü hızlı teklif formu (ana sayfa ve sayfa altları) --}}
<section class="bg-gradient-to-r from-gold-light to-gold-dark py-12">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex flex-col lg:flex-row items-center justify-between gap-8">
        <div class="text-background space-y-2 text-center lg:text-left">
            <h3 class="text-headline-md font-headline-md font-bold uppercase tracking-tight">Ücretsiz keşif ve teklif alın</h3>
            <p class="font-medium opacity-90">Mekanınızı uzman bakış açısıyla tasarlayalım.</p>
        </div>
        <form action="{{ route('teklif.store') }}" method="POST" class="w-full lg:w-auto space-y-2">
            @csrf
            <input type="hidden" name="kaynak" value="cta_bandi">
            {{-- Honeypot --}}
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
            <div class="flex flex-col sm:flex-row gap-3">
                <input name="ad" required placeholder="Adınız Soyadınız" class="bg-background/15 border border-background/20 text-background placeholder:text-background/60 rounded-lg px-5 py-3 focus:ring-2 focus:ring-background focus:outline-none">
                <input name="telefon" required type="tel" placeholder="Telefon Numaranız" class="bg-background/15 border border-background/20 text-background placeholder:text-background/60 rounded-lg px-5 py-3 focus:ring-2 focus:ring-background focus:outline-none">
                <button data-track="lead_form_submit" class="btn-sweep bg-background text-gold-light font-bold px-8 py-3 rounded-lg hover:bg-surface-container transition-all uppercase whitespace-nowrap">Gönder</button>
            </div>
            <label class="flex items-center gap-2 text-background/90 text-xs">
                <input type="checkbox" name="kvkk_onay" value="1" required class="rounded border-background/40">
                <a href="{{ route('kvkk') }}" target="_blank" class="underline">KVKK Aydınlatma Metni</a>'ni okudum, onaylıyorum.
            </label>
        </form>
    </div>
</section>
