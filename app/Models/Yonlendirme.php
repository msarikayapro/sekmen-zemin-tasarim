<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Yonlendirme extends Model
{
    protected $table = 'yonlendirmeler';

    protected $fillable = ['eski_url', 'yeni_url', 'tip', 'aktif', 'vurus'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public const CACHE_KEY = 'sekmen_yonlendirmeler';

    /** eski_url => [yeni_url, tip] (cache'li). */
    public static function harita(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::where('aktif', true)
                ->get(['eski_url', 'yeni_url', 'tip'])
                ->keyBy(fn ($y) => trim($y->eski_url, '/'))
                ->map(fn ($y) => ['yeni' => $y->yeni_url, 'tip' => $y->tip])
                ->all();
        });
    }

    public static function temizle(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
