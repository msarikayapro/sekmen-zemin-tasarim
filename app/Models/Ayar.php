<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ayar extends Model
{
    protected $table = 'ayarlar';

    protected $fillable = ['anahtar', 'deger'];

    public const CACHE_KEY = 'sekmen_ayarlar';

    /** Tüm ayarları key => value dizisi olarak (cache'li) döndürür. */
    public static function tumu(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::pluck('deger', 'anahtar')->all();
        });
    }

    public static function get(string $anahtar, $varsayilan = null)
    {
        return self::tumu()[$anahtar] ?? $varsayilan;
    }

    public static function set(string $anahtar, $deger): void
    {
        static::updateOrCreate(['anahtar' => $anahtar], ['deger' => $deger]);
        Cache::forget(self::CACHE_KEY);
    }

    /** Toplu kaydetme (panel form). */
    public static function topluKaydet(array $veriler): void
    {
        foreach ($veriler as $anahtar => $deger) {
            static::updateOrCreate(['anahtar' => $anahtar], ['deger' => $deger]);
        }
        Cache::forget(self::CACHE_KEY);
    }

    public static function temizle(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
