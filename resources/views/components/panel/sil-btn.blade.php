@props(['action', 'onay' => 'Bu kaydı silmek istediğinize emin misiniz?', 'ajax' => false])
@if($ajax)
    {{-- Bir formun İÇİNDE kullanım için: nested form yerine fetch ile siler.
         Nested form tarayıcıda düzleşince @method('DELETE') dış forma sızıp
         yanlış kaydı siliyordu (galeri görseli silince ürün/proje siliniyordu). --}}
    <button type="button" data-sil-url="{{ $action }}" data-sil-onay="{{ $onay }}"
        {{ $attributes->merge(['class' => 'text-stone-grey hover:text-error transition-colors p-1.5 rounded-lg']) }} title="Sil">
        <span class="material-symbols-outlined text-xl">delete</span>
    </button>
@else
    {{-- Bağımsız silme formu (nested form yok — Deploy Anayasası §6) --}}
    <form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $onay }}')" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" {{ $attributes->merge(['class' => 'text-stone-grey hover:text-error transition-colors p-1.5 rounded-lg']) }} title="Sil">
            <span class="material-symbols-outlined text-xl">delete</span>
        </button>
    </form>
@endif
