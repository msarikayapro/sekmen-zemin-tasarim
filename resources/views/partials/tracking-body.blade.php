@php($pz = $pazarlamaAyari)
{{-- GTM noscript (body başı) --}}
@if($pz && $pz->gtm_id)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $pz->gtm_id }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

{{-- Özel <body> kod enjeksiyonu (panel) --}}
@if($pz && $pz->body_kod)
    {!! $pz->body_kod !!}
@endif
