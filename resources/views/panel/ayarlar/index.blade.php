@extends('layouts.panel')
@section('baslik', 'Genel Ayarlar')

@section('content')
    <x-panel.baslik baslik="Genel Ayarlar" aciklama="Site geneli bilgiler, iletişim, sosyal medya ve görseller." />
    <form method="POST" action="{{ route('panel.ayarlar.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @php($a = fn($k, $d='') => $ayarlar[$k] ?? $d)

        <x-panel.card baslik="Site Kimliği">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-panel.input label="Site Başlığı" name="site_basligi" :value="$a('site_basligi')" />
                <x-panel.input label="Tema Rengi" name="tema_renk" :value="$a('tema_renk','#B6863E')" type="color" />
            </div>
            <x-panel.input label="Slogan / Hero Başlık" name="slogan" :value="$a('slogan')" />
        </x-panel.card>

        <x-panel.card baslik="Rakamlarla Biz">
            <label class="flex items-center gap-3 mb-4 cursor-pointer select-none">
                <input type="checkbox" name="rakamlar_aktif" value="1" @checked($a('rakamlar_aktif', '1'))
                       class="w-5 h-5 rounded border-outline-variant bg-surface-container-lowest text-gold-light focus:ring-gold-light">
                <span class="text-sm text-on-surface">Bu bölümü anasayfada göster <span class="text-stone-grey">(kapatırsanız sayaç bölümü gizlenir)</span></span>
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-panel.input label="Kuruluş Yılı" name="kurulus_yili" :value="$a('kurulus_yili')" />
                <x-panel.input label="Uygulama m²" name="uygulama_m2" :value="$a('uygulama_m2')" />
                <x-panel.input label="Proje Sayısı" name="proje_sayisi" :value="$a('proje_sayisi')" />
                <x-panel.input label="Mutlu Müşteri" name="mutlu_musteri" :value="$a('mutlu_musteri')" />
            </div>
        </x-panel.card>

        <x-panel.card baslik="İletişim">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-panel.input label="Telefon" name="telefon" :value="$a('telefon')" />
                <x-panel.input label="Telefon 2 / Faks" name="telefon2" :value="$a('telefon2')" />
                <x-panel.input label="WhatsApp Numara (905...)" name="whatsapp" :value="$a('whatsapp')" />
                <x-panel.input label="E-posta" name="email" :value="$a('email')" />
            </div>
            <x-panel.input label="WhatsApp Hazır Mesaj" name="whatsapp_mesaj" :value="$a('whatsapp_mesaj')" />
            <x-panel.textarea label="Adres" name="adres" :value="$a('adres')" rows="2" />
            <x-panel.input label="Çalışma Saatleri" name="calisma_saatleri" :value="$a('calisma_saatleri')" />
            <x-panel.textarea label="Google Maps Embed URL" name="harita_embed" :value="$a('harita_embed')" rows="2" help="Google Maps > Paylaş > Harita yerleştir > src değeri." />
            <x-panel.input label="Hizmet Bölgeleri" name="hizmet_bolgeleri" :value="$a('hizmet_bolgeleri')" />
            <x-panel.textarea label="Footer Açıklaması" name="footer_aciklama" :value="$a('footer_aciklama')" rows="2" />
        </x-panel.card>

        <x-panel.card baslik="Sosyal Medya">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-panel.input label="Instagram" name="sosyal_instagram" :value="$a('sosyal_instagram')" />
                <x-panel.input label="Facebook" name="sosyal_facebook" :value="$a('sosyal_facebook')" />
                <x-panel.input label="YouTube" name="sosyal_youtube" :value="$a('sosyal_youtube')" />
            </div>
        </x-panel.card>

        <x-panel.card baslik="Görseller & Katalog">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(['logo'=>'Logo (açık)','logo_koyu'=>'Logo (koyu zemin)','favicon'=>'Favicon'] as $k=>$l)
                    <div class="space-y-1.5">
                        <label class="block font-label-caps text-[11px] text-stone-grey uppercase">{{ $l }}</label>
                        @if($a($k))<img src="{{ gorsel($a($k)) }}" class="h-12 mb-2 object-contain bg-surface-container rounded p-1" alt="">@endif
                        <input type="file" name="{{ $k }}" accept="image/*" class="block w-full text-xs text-stone-grey file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
                    </div>
                @endforeach
            </div>
            <div class="space-y-1.5">
                <label class="block font-label-caps text-[11px] text-stone-grey uppercase">Katalog PDF</label>
                @if($a('katalog_pdf'))<a href="{{ gorsel($a('katalog_pdf')) }}" target="_blank" class="text-gold-light text-sm">Mevcut katalog →</a>@endif
                <input type="file" name="katalog_pdf" accept="application/pdf" class="block w-full text-xs text-stone-grey file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </div>
        </x-panel.card>

        <x-panel.kaydet-bar />
    </form>
@endsection
