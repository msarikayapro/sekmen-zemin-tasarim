@props(['href', 'label' => 'Yeni Ekle'])
<a href="{{ $href }}" class="inline-flex items-center gap-2 bg-gold-light text-background px-5 py-2.5 rounded-lg font-label-caps text-xs font-bold uppercase hover:bg-gold-dark transition-colors">
    <span class="material-symbols-outlined text-lg">add</span> {{ $label }}
</a>
