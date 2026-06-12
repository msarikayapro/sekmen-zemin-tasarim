@extends('layouts.panel')
@section('baslik', $kullanici->exists ? 'Kullanıcı Düzenle' : 'Yeni Kullanıcı')

@section('content')
    <x-panel.baslik :baslik="$kullanici->exists ? $kullanici->name : 'Yeni Kullanıcı'" />
    <form method="POST" action="{{ $kullanici->exists ? route('panel.kullanicilar.update', $kullanici) : route('panel.kullanicilar.store') }}" class="max-w-2xl space-y-6">
        @csrf @if($kullanici->exists) @method('PUT') @endif
        <x-panel.card>
            <div class="grid grid-cols-2 gap-4">
                <x-panel.input label="Ad Soyad" name="name" :value="$kullanici->name" required />
                <x-panel.input label="E-posta" name="email" type="email" :value="$kullanici->email" required />
                <x-panel.input label="Telefon" name="telefon" :value="$kullanici->telefon" />
                <x-panel.select label="Rol" name="rol" :value="$kullanici->rol" :options="['editor'=>'Editör','admin'=>'Yönetici']" />
            </div>
            <x-panel.input label="Şifre" name="password" type="password" :help="$kullanici->exists ? 'Değiştirmek istemiyorsanız boş bırakın.' : 'En az 8 karakter.'" :required="! $kullanici->exists" />
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $kullanici->aktif ?? true)) class="rounded border-outline-variant bg-surface-container-lowest text-gold-dark focus:ring-gold-light">
                <span class="text-sm text-on-surface">Hesap aktif</span>
            </label>
        </x-panel.card>
        <x-panel.kaydet-bar :geri="route('panel.kullanicilar.index')" />
    </form>
@endsection
