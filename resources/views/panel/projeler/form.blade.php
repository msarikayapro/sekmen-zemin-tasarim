@extends('layouts.panel')
@section('baslik', $proje->exists ? 'Proje Düzenle' : 'Yeni Proje')

@section('content')
    <x-panel.baslik :baslik="$proje->exists ? $proje->baslik : 'Yeni Proje'" />
    <form method="POST" action="{{ $proje->exists ? route('panel.projeler.update', $proje) : route('panel.projeler.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf @if($proje->exists) @method('PUT') @endif
        <div class="lg:col-span-2 space-y-6">
            <x-panel.card baslik="Proje Bilgileri">
                <x-panel.input label="Başlık" name="baslik" :value="$proje->baslik" required />
                <x-panel.input label="Slug" name="slug" :value="$proje->slug" help="Boş bırakılırsa otomatik." />
                <div class="grid grid-cols-2 gap-4">
                    <x-panel.select label="Tip" name="tip" :value="$proje->tip" :options="\App\Models\Proje::TIPLER" />
                    <x-panel.input label="Konum (Şehir/İlçe)" name="konum" :value="$proje->konum" />
                    <x-panel.input label="Tarih / Yıl" name="tarih" :value="$proje->tarih" />
                    <x-panel.input label="Video URL" name="video_url" :value="$proje->video_url" />
                </div>
                <x-panel.textarea label="Açıklama" name="aciklama" :value="$proje->aciklama" rows="4" />
            </x-panel.card>
            <x-panel.card baslik="Müşteri Yorumu (opsiyonel)">
                <x-panel.input label="Müşteri Adı" name="musteri_adi" :value="$proje->musteri_adi" />
                <x-panel.textarea label="Müşteri Yorumu" name="musteri_yorumu" :value="$proje->musteri_yorumu" rows="3" />
            </x-panel.card>
            <x-panel.card baslik="Galeri Görselleri">
                @if($proje->exists && $proje->gorseller->isNotEmpty())
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach($proje->gorseller as $g)
                            <div class="relative group">
                                <img src="{{ gorsel($g->yol) }}" class="w-full aspect-square object-cover rounded-lg" alt="">
                                <x-panel.sil-btn :ajax="true" :action="route('panel.projeler.gorsel.sil', $g)" onay="Bu görseli silmek istiyor musunuz?" class="absolute top-1 right-1 bg-background/80 !text-error opacity-0 group-hover:opacity-100" />
                            </div>
                        @endforeach
                    </div>
                @endif
                <input type="file" name="galeri[]" multiple accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </x-panel.card>
        </div>
        <div class="space-y-6">
            <x-panel.card baslik="Yayın">
                <x-panel.select label="Durum" name="durum" :value="$proje->durum" :options="['yayin'=>'Yayında','taslak'=>'Taslak']" />
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="one_cikan" value="1" @checked($proje->one_cikan) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    <span class="text-sm text-on-surface">Ana sayfada öne çıkar</span>
                </label>
                <x-panel.input label="Sıra" name="sira" type="number" :value="$proje->sira" />
            </x-panel.card>
            <x-panel.card baslik="Kapak Görseli">
                @if($proje->kapak_gorsel)<img src="{{ gorsel($proje->kapak_gorsel) }}" class="w-full aspect-video object-cover rounded-lg mb-3" alt="">@endif
                <input type="file" name="kapak_gorsel" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </x-panel.card>
            <x-panel.card baslik="Kullanılan Taş Çeşitleri">
                <div class="max-h-64 overflow-y-auto space-y-2 pr-2">
                    @foreach($urunler as $u)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="urunler[]" value="{{ $u->id }}" @checked(in_array($u->id, old('urunler', $secili))) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                            <span class="text-sm text-on-surface">{{ $u->ad }}</span>
                        </label>
                    @endforeach
                </div>
            </x-panel.card>
            <x-panel.kaydet-bar :geri="route('panel.projeler.index')" />
        </div>
    </form>
@endsection
