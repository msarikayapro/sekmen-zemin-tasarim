@extends('layouts.panel')
@section('baslik', $showcase->exists ? 'Vitrin Düzenle' : 'Yeni Vitrin')

@section('content')
    <x-panel.baslik :baslik="$showcase->exists ? 'Vitrin Düzenle' : 'Yeni Vitrin'" aciklama="Tip seçimine göre alanlar değişir. Video için dikey kapak fotoğrafı zorunludur." />

    <form method="POST" action="{{ $showcase->exists ? route('panel.showcases.update', $showcase) : route('panel.showcases.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @if($showcase->exists) @method('PUT') @endif

        <x-panel.card baslik="İçerik">
            <x-panel.select label="Tip" name="type" :value="$showcase->type" :options="['image' => 'Görsel', 'video' => 'Video']" required />

            {{-- Medya dosyası (tipe göre etiket/accept değişir) --}}
            <div class="space-y-1.5">
                <label for="media" class="block font-label-caps text-[11px] text-stone-grey uppercase">
                    <span id="media-label">Görsel</span> @unless($showcase->exists)<span class="text-gold-light">*</span>@endunless
                </label>

                {{-- Mevcut medya önizleme --}}
                @if($showcase->exists && $showcase->media_path)
                    <div class="mb-2">
                        @if($showcase->isVideo())
                            <video src="{{ gorsel($showcase->media_path) }}" class="w-40 aspect-[9/16] object-cover rounded-lg border border-surface-variant" muted controls></video>
                        @else
                            <img src="{{ gorsel($showcase->media_path) }}" class="w-40 aspect-[3/4] object-cover rounded-lg border border-surface-variant" alt="">
                        @endif
                    </div>
                @endif

                <input type="file" name="media" id="media" accept="image/*" @unless($showcase->exists) required @endunless
                       class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold file:cursor-pointer">
                <p class="text-xs text-stone-grey" id="media-help">Önerilen: dikey/kare görsel. Maks. 8 MB.</p>
                @error('media')<p class="text-xs text-error">{{ $message }}</p>@enderror
            </div>

            {{-- Kapak fotoğrafı (yalnızca video) --}}
            <div class="space-y-1.5 hidden" id="thumb-block">
                <label for="thumbnail" class="block font-label-caps text-[11px] text-stone-grey uppercase">
                    Kapak Fotoğrafı (Thumbnail) <span class="text-gold-light">*</span>
                </label>
                @if($showcase->exists && $showcase->thumbnail_path)
                    <img src="{{ gorsel($showcase->thumbnail_path) }}" class="w-40 aspect-[3/4] object-cover rounded-lg border border-surface-variant mb-2" alt="">
                @endif
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                       class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold file:cursor-pointer">
                <p class="text-xs text-stone-grey">Videonun dikey tasarımda düzgün görünmesi için kapak (örn. 3/4 veya 9/16). Maks. 8 MB.</p>
                @error('thumbnail')<p class="text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 items-end">
                <x-panel.input label="Sıra" name="order" type="number" :value="$showcase->order" help="Küçük sayı önce gösterilir." />
                <label class="flex items-center gap-3 cursor-pointer pb-3">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $showcase->is_active ?? true)) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    <span class="text-sm text-on-surface">Yayında (aktif)</span>
                </label>
            </div>
        </x-panel.card>

        <x-panel.kaydet-bar :geri="route('panel.showcases.index')" />
    </form>

    @push('scripts')
    <script>
        (function () {
            const typeSel    = document.getElementById('type');
            const mediaInput = document.getElementById('media');
            const mediaLabel = document.getElementById('media-label');
            const mediaHelp  = document.getElementById('media-help');
            const thumbBlock = document.getElementById('thumb-block');
            const thumbInput = document.getElementById('thumbnail');
            const isNew      = {{ $showcase->exists ? 'false' : 'true' }};

            function syncTip() {
                if (typeSel.value === 'video') {
                    mediaInput.setAttribute('accept', 'video/mp4,video/webm');
                    mediaLabel.textContent = 'Video Dosyası (MP4 / WEBM)';
                    mediaHelp.textContent = 'Maks. 50 MB. Dikey video önerilir.';
                    thumbBlock.classList.remove('hidden');
                    if (isNew) thumbInput.setAttribute('required', 'required');
                } else {
                    mediaInput.setAttribute('accept', 'image/*');
                    mediaLabel.textContent = 'Görsel (JPG / PNG / WEBP)';
                    mediaHelp.textContent = 'Önerilen: dikey/kare görsel. Maks. 8 MB.';
                    thumbBlock.classList.add('hidden');
                    thumbInput.removeAttribute('required');
                }
            }

            typeSel.addEventListener('change', syncTip);
            syncTip();
        })();
    </script>
    @endpush
@endsection
