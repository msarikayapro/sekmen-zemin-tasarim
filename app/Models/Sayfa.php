<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sayfa extends Model
{
    protected $table = 'sayfalar';

    protected $fillable = ['anahtar', 'baslik', 'bloklar', 'icerik', 'meta_title', 'meta_desc', 'og_image'];

    protected $casts = [
        'bloklar' => 'array',
    ];

    public static function anahtar(string $key): ?self
    {
        return static::where('anahtar', $key)->first();
    }
}
