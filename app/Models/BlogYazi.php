<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BlogYazi extends Model
{
    protected $table = 'blog_yazilari';

    protected $fillable = [
        'baslik', 'slug', 'ozet', 'icerik', 'kapak', 'etiketler', 'kategori',
        'meta_title', 'meta_desc', 'durum', 'yayin_tarihi',
    ];

    protected $casts = [
        'etiketler'    => 'array',
        'yayin_tarihi' => 'datetime',
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
