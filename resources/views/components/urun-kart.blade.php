@props(['urun'])
<div class="group bg-surface-container-high rounded-xl overflow-hidden border border-surface-variant/30 gold-glow reveal">
    <a href="{{ route('urunler.show', $urun) }}" class="block h-60 overflow-hidden">
        <img src="{{ gorsel($urun->kapak) }}" alt="{{ $urun->ad }} parke taşı" loading="lazy"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    </a>
    <div class="p-6 space-y-3">
        <div class="flex justify-between items-start gap-2">
            <h3 class="font-headline-md text-xl text-cream-white">{{ $urun->ad }}</h3>
            @if($urun->kalinlik)
                <span class="shrink-0 bg-surface-variant text-stone-grey px-2 py-1 rounded text-[10px] font-bold uppercase">{{ $urun->kalinlik }}</span>
            @endif
        </div>
        <p class="text-stone-grey text-sm line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($urun->aciklama), 70) }}</p>
        <a href="{{ route('urunler.show', $urun) }}" class="inline-flex items-center text-gold-light font-label-caps text-label-caps gap-2 uppercase">
            İncele <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </a>
    </div>
</div>
