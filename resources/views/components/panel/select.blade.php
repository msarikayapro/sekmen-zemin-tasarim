@props(['label' => null, 'name', 'value' => null, 'options' => [], 'required' => false])
<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block font-label-caps text-[11px] text-stone-grey uppercase">{{ $label }} @if($required)<span class="text-gold-light">*</span>@endif</label>
    @endif
    <select name="{{ $name }}" id="{{ $name }}" @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 text-on-surface focus:border-gold-light focus:ring-1 focus:ring-gold-light focus:outline-none transition-colors']) }}>
        @foreach($options as $deger => $etiket)
            <option value="{{ $deger }}" @selected((string) old($name, $value) === (string) $deger)>{{ $etiket }}</option>
        @endforeach
    </select>
    @error($name)<p class="text-xs text-error">{{ $message }}</p>@enderror
</div>
