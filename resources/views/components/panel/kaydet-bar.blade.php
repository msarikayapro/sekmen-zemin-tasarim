@props(['geri' => null])
<div class="flex items-center justify-end gap-3 pt-2 sticky bottom-0 lg:bottom-auto">
    @if($geri)
        <a href="{{ $geri }}" class="px-5 py-3 rounded-lg border border-surface-variant text-stone-grey hover:text-on-surface text-sm font-label-caps uppercase">İptal</a>
    @endif
    <button type="submit" class="btn-sweep bg-gold-light text-background font-bold px-8 py-3 rounded-lg uppercase tracking-wide text-sm hover:bg-gold-dark transition-colors flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">save</span> Kaydet
    </button>
</div>
