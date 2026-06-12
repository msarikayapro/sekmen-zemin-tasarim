@props(['action', 'onay' => 'Bu kaydı silmek istediğinize emin misiniz?'])
{{-- Bağımsız silme formu (nested form yok — Deploy Anayasası §6) --}}
<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $onay }}')" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->merge(['class' => 'text-stone-grey hover:text-error transition-colors p-1.5 rounded-lg']) }} title="Sil">
        <span class="material-symbols-outlined text-xl">delete</span>
    </button>
</form>
