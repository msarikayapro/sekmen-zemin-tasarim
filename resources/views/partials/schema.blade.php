{{-- LocalBusiness yapısal verisi (yerel SEO) --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => ayar('site_basligi', 'Sekmen Zemin Tasarım'),
    'image' => gorsel(ayar('logo')),
    'description' => ayar('slogan'),
    '@id' => url('/'),
    'url' => url('/'),
    'telephone' => ayar('telefon'),
    'email' => ayar('email'),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => ayar('adres'),
        'addressLocality' => 'Konya',
        'addressCountry' => 'TR',
    ],
    'areaServed' => ayar('hizmet_bolgeleri'),
    'foundingDate' => ayar('kurulus_yili'),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

{{-- FAQPage: yalnızca sayfada gerçekten render edilen SSS'lerden (controller'dan gelir) --}}
@isset($faqSchema)
    @if($faqSchema)
        <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    @endif
@endisset
