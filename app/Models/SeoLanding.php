<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SeoLanding extends Model
{
    protected $table = 'seo_landing';

    protected $fillable = [
        'baslik_h1', 'slug', 'sehir', 'urun_tipi', 'icerik', 'gorseller',
        'meta_title', 'meta_desc', 'durum',
    ];

    protected $casts = [
        'gorseller' => 'array',
    ];

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
