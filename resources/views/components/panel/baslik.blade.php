@props(['baslik', 'aciklama' => null])
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="font-headline-md text-2xl md:text-headline-md text-cream-white">{{ $baslik }}</h1>
        @if($aciklama)<p class="text-stone-grey text-sm mt-1">{{ $aciklama }}</p>@endif
    </div>
    @if(isset($aksiyon))
        <div class="flex gap-2">{{ $aksiyon }}</div>
    @endif
</div>
