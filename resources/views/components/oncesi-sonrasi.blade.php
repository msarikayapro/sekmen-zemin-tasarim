@props(['kayit'])
{{-- Öncesi/Sonrası karşılaştırma slider --}}
<div data-ba class="before-after-container aspect-video rounded-2xl overflow-hidden shadow-2xl relative bg-surface-container">
    <img src="{{ gorsel($kayit->sonrasi_gorsel) }}" alt="{{ $kayit->baslik }} sonrası" loading="lazy" class="absolute inset-0 w-full h-full object-cover z-0">
    <div data-ba-before class="absolute inset-0 z-10 w-1/2 overflow-hidden border-r-4 border-gold-light">
        <img src="{{ gorsel($kayit->oncesi_gorsel) }}" alt="{{ $kayit->baslik }} öncesi" loading="lazy" class="absolute inset-0 h-full object-cover max-w-none" style="width:100vw;max-width:1280px">
    </div>
    <div class="slider-handle" style="left:50%"></div>
    <span class="absolute top-3 left-3 z-20 bg-background/70 text-stone-grey text-[10px] uppercase tracking-widest px-3 py-1 rounded-full">Öncesi</span>
    <span class="absolute top-3 right-3 z-20 bg-gold-light/90 text-background text-[10px] uppercase tracking-widest px-3 py-1 rounded-full font-bold">Sonrası</span>
</div>
@if($kayit->baslik)
    <p class="text-center text-stone-grey text-sm mt-4">{{ $kayit->baslik }}</p>
@endif
