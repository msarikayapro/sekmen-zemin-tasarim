@props(['ssler', 'baslik' => 'Sıkça Sorulan Sorular'])
@if($ssler->isNotEmpty())
<section class="py-20 md:py-24 bg-surface">
    <div class="max-w-3xl mx-auto px-margin-mobile">
        <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-12 text-center uppercase tracking-wide text-cream-white reveal">{{ $baslik }}</h2>
        <div class="space-y-4" data-accordion>
            @foreach($ssler as $sss)
                <div class="accordion-item border border-surface-variant rounded-xl bg-surface-container-low reveal">
                    <button type="button" class="w-full px-6 py-5 flex justify-between items-center text-left gap-4">
                        <span class="font-headline-md text-base md:text-lg text-cream-white">{{ $sss->soru }}</span>
                        <span class="material-symbols-outlined text-gold-light icon-rotate transition-transform shrink-0">expand_more</span>
                    </button>
                    <div class="accordion-content">
                        <div class="px-6 pb-5 text-stone-grey font-body-md leading-relaxed prose-invert">{!! nl2br(e($sss->cevap)) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
