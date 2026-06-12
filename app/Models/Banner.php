<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'bannerlar';

    protected $fillable = ['gorsel', 'baslik', 'alt_baslik', 'alt_metin', 'buton_yazi', 'link', 'sira', 'durum'];

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira');
    }
}
