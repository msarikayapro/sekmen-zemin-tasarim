<?php

namespace App\Support;

use App\Models\Sss;
use Illuminate\Support\Collection;

class SssService
{
    /** Belirli bir sayfada görünecek aktif SSS'ler (sayfa-bazlı filtreden geçenler). */
    public static function sayfaSsleri(string $sayfa): Collection
    {
        return Sss::yayinda()->sayfada($sayfa)->sirali()->get();
    }

    /**
     * Sadece sayfada GERÇEKTEN render edilen SSS'lerden FAQPage JSON-LD üretir.
     * (Google "görünmeyen içerik schema'ya konmaz" kuralına uyum.)
     */
    public static function faqSchema(Collection $ssler): ?array
    {
        if ($ssler->isEmpty()) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $ssler->map(fn (Sss $s) => [
                '@type' => 'Question',
                'name' => $s->soru,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($s->cevap),
                ],
            ])->values()->all(),
        ];
    }
}
