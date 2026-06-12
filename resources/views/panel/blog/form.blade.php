@extends('layouts.panel')
@section('baslik', $yazi->exists ? 'Yazı Düzenle' : 'Yeni Yazı')

@section('content')
    <x-panel.baslik :baslik="$yazi->exists ? 'Yazı Düzenle' : 'Yeni Blog Yazısı'" />
    <form method="POST" action="{{ $yazi->exists ? route('panel.blog.update', $yazi) : route('panel.blog.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf @if($yazi->exists) @method('PUT') @endif
        <div class="lg:col-span-2 space-y-6">
            <x-panel.card>
                <x-panel.input label="Başlık" name="baslik" :value="$yazi->baslik" required />
                <x-panel.input label="Slug" name="slug" :value="$yazi->slug" help="Boş bırakılırsa otomatik." />
                <x-panel.textarea label="Özet" name="ozet" :value="$yazi->ozet" rows="2" />
                <x-panel.textarea label="İçerik (HTML destekli)" name="icerik" :value="$yazi->icerik" rows="12" />
            </x-panel.card>
            <x-panel.card baslik="SEO">
                <x-panel.input label="Meta Title" name="meta_title" :value="$yazi->meta_title" />
                <x-panel.textarea label="Meta Description" name="meta_desc" :value="$yazi->meta_desc" rows="2" />
            </x-panel.card>
        </div>
        <div class="space-y-6">
            <x-panel.card baslik="Yayın">
                <x-panel.select label="Durum" name="durum" :value="$yazi->durum" :options="['taslak'=>'Taslak','yayin'=>'Yayında']" />
                <x-panel.input label="Kategori" name="kategori" :value="$yazi->kategori" />
                <x-panel.input label="Etiketler" name="etiketler" :value="$yazi->etiketler ? implode(', ', $yazi->etiketler) : ''" help="Virgülle ayırın." />
            </x-panel.card>
            <x-panel.card baslik="Kapak">
                @if($yazi->kapak)<img src="{{ gorsel($yazi->kapak) }}" class="w-full aspect-video object-cover rounded-lg mb-2" alt="">@endif
                <input type="file" name="kapak" accept="image/*" class="block w-full text-sm text-stone-grey file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-light file:text-background file:font-bold">
            </x-panel.card>
            <x-panel.kaydet-bar :geri="route('panel.blog.index')" />
        </div>
    </form>
@endsection
