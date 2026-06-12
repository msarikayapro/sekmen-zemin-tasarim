@props(['ust' => null, 'baslik', 'aciklama' => null, 'ortala' => true])
<div class="{{ $ortala ? 'text-center mx-auto max-w-2xl' : '' }} mb-12 space-y-4 reveal">
    @if($ust)
        <span class="text-gold-light font-label-caps text-label-caps tracking-widest uppercase">{{ $ust }}</span>
    @endif
    <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg text-cream-white">{{ $baslik }}</h2>
    @if($aciklama)
        <p class="text-stone-grey leading-relaxed">{{ $aciklama }}</p>
    @endif
</div>
