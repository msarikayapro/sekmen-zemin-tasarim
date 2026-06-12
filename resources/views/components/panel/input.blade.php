@props(['label' => null, 'name', 'value' => null, 'type' => 'text', 'required' => false, 'help' => null])
<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block font-label-caps text-[11px] text-stone-grey uppercase">{{ $label }} @if($required)<span class="text-gold-light">*</span>@endif</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
           value="{{ old($name, $value) }}" @if($required) required @endif
           {{ $attributes->merge(['class' => 'w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none transition-colors']) }}>
    @if($help)<p class="text-xs text-stone-grey">{{ $help }}</p>@endif
    @error($name)<p class="text-xs text-error">{{ $message }}</p>@enderror
</div>
