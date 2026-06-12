@props(['baslik' => null])
<div {{ $attributes->merge(['class' => 'bg-surface-container-low border border-surface-variant rounded-2xl p-5 md:p-6 space-y-4']) }}>
    @if($baslik)
        <h3 class="font-headline-md text-lg text-cream-white border-b border-surface-variant/60 pb-3">{{ $baslik }}</h3>
    @endif
    {{ $slot }}
</div>
