<x-mail::message>
# Yeni Teklif Talebi

Web sitesi üzerinden yeni bir teklif/iletişim talebi geldi.

**Ad Soyad:** {{ $talep->ad }}
**Telefon:** {{ $talep->telefon }}
@if($talep->email)**E-posta:** {{ $talep->email }}@endif

@if($talep->il_ilce)**İl/İlçe:** {{ $talep->il_ilce }}@endif

@if($talep->ilgi_alani)**İlgilenilen Ürün/Hizmet:** {{ $talep->ilgi_alani }}@endif

@if($talep->m2)**Yaklaşık Alan:** {{ $talep->m2 }} m²@endif

@if($talep->mesaj)
**Mesaj:**
{{ $talep->mesaj }}
@endif

**Kaynak:** {{ $talep->kaynak ?? 'web' }}
**Tarih:** {{ $talep->created_at->format('d.m.Y H:i') }}

<x-mail::button :url="config('app.url') . '/panel/talepler/' . $talep->id">
Panelde Görüntüle
</x-mail::button>

Sekmen Zemin Tasarım
</x-mail::message>
