@extends('layouts.panel')
@section('baslik', $urun->exists ? 'Ürün Düzenle' : 'Yeni Ürün')

@section('content')
    <x-panel.baslik :baslik="$urun->exists ? $urun->ad : 'Yeni Ürün'" aciklama="Ürün bilgileri, teknik özellikler ve galeri." />

    <form method="POST" action="{{ $urun->exists ? route('panel.urunler.update', $urun) : route('panel.urunler.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @if($urun->exists) @method('PUT') @endif

        <div class="lg:col-span-2 space-y-6">
            <x-panel.card baslik="Genel Bilgiler">
                <x-panel.input label="Ürün Adı" name="ad" :value="$urun->ad" required />
                <x-panel.input label="Slug (URL)" name="slug" :value="$urun->slug" help="Boş bırakılırsa addan otomatik üretilir." />
                <x-panel.textarea label="Açıklama" name="aciklama" :value="$urun->aciklama" rows="4" />
            </x-panel.card>

            <x-panel.card baslik="Teknik Özellikler">
                <div class="grid grid-cols-2 gap-4">
                    <x-panel.input label="Ebat (En)" name="ebat_en" :value="$urun->ebat_en" />
                    <x-panel.input label="Ebat (Boy)" name="ebat_boy" :value="$urun->ebat_boy" />
                    <x-panel.input label="Kalınlık" name="kalinlik" :value="$urun->kalinlik" />
                    <x-panel.input label="m² Adedi" name="m2_adet" :value="$urun->m2_adet" />
                    <x-panel.input label="Palet Bilgisi" name="palet_bilgi" :value="$urun->palet_bilgi" />
                    <x-panel.input label="Video URL (YouTube)" name="video_url" :value="$urun->video_url" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-panel.textarea label="Renk Seçenekleri" name="renkler" :value="$urun->renk_secenekleri ? implode(\"\n\", $urun->renk_secenekleri) : ''" rows="3" help="Her satıra bir renk." />
                    <x-panel.textarea label="Kullanım Alanları" name="kullanim" :value="$urun->kullanim_alanlari ? implode(\"\n\", $urun->kullanim_alanlari) : ''" rows="3" help="Her satıra bir alan." />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-panel.input label="Dayanım" name="dayanim" :value="$urun->dayanim" />
                    <x-panel.input label="Don Direnci" name="don_direnci" :value="$urun->don_direnci" />
                </div>
            </x-panel.card>

            <x-panel.card baslik="Galeri Görselleri">
                @if($urun->exists && $urun->gorseller->isNotEmpty())
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach($urun->gorseller as $g)
                            <div class="relative group">
                                <img src="{{ gorsel($g->yol) }}" class="w-full aspect-square object-cover rounded-lg" alt="">
                                <x-panel.sil-btn :action="route('panel.urunler.gorsel.sil', $g)" onay="Bu görseli silmek istiyor musunuz?" class="absolute top-1 right-1 bg-background/80 !text-error opacity-0 group-hover:opacity-100" />
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="space-y-1.5">
                    <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Görsel Ekle (çoklu seçilebilir)</label>
                    <input type="file" name="galeri[]" multiple accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold file:cursor-pointer">
                </div>
            </x-panel.card>

            <x-panel.card baslik="SEO">
                <x-panel.input label="Meta Title" name="meta_title" :value="$urun->meta_title" />
                <x-panel.textarea label="Meta Description" name="meta_desc" :value="$urun->meta_desc" rows="2" />
            </x-panel.card>
        </div>

        <div class="space-y-6">
            <x-panel.card baslik="Yayın">
                <x-panel.select label="Durum" name="durum" :value="$urun->durum" :options="['yayin' => 'Yayında', 'taslak' => 'Taslak']" />
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="one_cikan" value="1" @checked($urun->one_cikan) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                    <span class="text-sm text-on-surface">Ana sayfada öne çıkar</span>
                </label>
                <x-panel.input label="Sıra" name="sira" type="number" :value="$urun->sira" />
            </x-panel.card>

            <x-panel.card baslik="Kapak Görseli">
                @if($urun->one_cikan_gorsel)<img src="{{ gorsel($urun->one_cikan_gorsel) }}" class="w-full aspect-square object-cover rounded-lg mb-3" alt="">@endif
                <input type="file" name="one_cikan_gorsel" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold file:cursor-pointer">
            </x-panel.card>

            <x-panel.card baslik="Kategoriler">
                <div class="space-y-2">
                    @foreach($kategoriler as $kat)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="kategoriler[]" value="{{ $kat->id }}" @checked(in_array($kat->id, old('kategoriler', $secili))) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                            <span class="text-sm text-on-surface">{{ $kat->ad }}</span>
                        </label>
                    @endforeach
                </div>
            </x-panel.card>

            <x-panel.kaydet-bar :geri="route('panel.urunler.index')" />
        </div>
    </form>
@endsection
