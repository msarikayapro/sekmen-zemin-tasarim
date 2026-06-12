<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PazarlamaAyari extends Model
{
    protected $table = 'pazarlama_ayarlari';

    protected $fillable = [
        'meta_pixel_id', 'meta_pixel_aktif', 'capi_token', 'capi_test_code', 'capi_aktif',
        'ga4_id', 'gtm_id', 'google_ads_id', 'google_ads_label', 'search_console_meta',
        'head_kod', 'body_kod', 'event_mapping',
    ];

    protected $casts = [
        'meta_pixel_aktif' => 'boolean',
        'capi_aktif'       => 'boolean',
        'capi_token'       => 'encrypted', // Deploy Anayasası §M9: token şifreli saklanır
        'event_mapping'    => 'array',
    ];

    public const CACHE_KEY = 'sekmen_pazarlama';

    /**
     * Tek satır — yoksa boş bir örnek döndürür.
     * Not: Eloquent modeli file/array cache'e SERİLEŞTİRİLMEZ (__PHP_Incomplete_Class
     * sorununu önlemek için); request başına tek küçük sorgu yeterlidir.
     */
    public static function tekil(): self
    {
        return static::first() ?: new self([
            'event_mapping' => self::varsayilanEventMapping(),
        ]);
    }

    public static function temizle(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Site aksiyonu → Meta event eşleştirmesi (varsayılan harita).
     * standard=false ise trackCustom kullanılır.
     */
    public static function varsayilanEventMapping(): array
    {
        return [
            'whatsapp_click'   => ['meta' => 'Lead',              'active' => true,  'standard' => true],
            'phone_click'      => ['meta' => 'Contact',           'active' => true,  'standard' => true],
            'email_click'      => ['meta' => 'Contact',           'active' => true,  'standard' => true],
            'lead_form_submit' => ['meta' => 'Lead',              'active' => true,  'standard' => true],
            'campaign_click'   => ['meta' => 'InitiateCheckout',  'active' => true,  'standard' => true],
            'urun_view'        => ['meta' => 'ViewContent',       'active' => true,  'standard' => true],
            'gallery_view'     => ['meta' => 'ViewContent',       'active' => true,  'standard' => true],
            'scroll_depth'     => ['meta' => 'ScrollDepth',       'active' => false, 'standard' => false],
            'time_on_page'     => ['meta' => 'TimeOnPage',        'active' => false, 'standard' => false],
            'page_view'        => ['meta' => 'PageView',          'active' => true,  'standard' => true],
        ];
    }

    public function aktifEventHaritasi(): array
    {
        return $this->event_mapping ?: self::varsayilanEventMapping();
    }
}
