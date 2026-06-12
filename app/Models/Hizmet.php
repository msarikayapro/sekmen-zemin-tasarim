<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Hizmet extends Model
{
    protected $table = 'hizmetler';

    protected $fillable = ['ad', 'slug', 'ikon', 'aciklama', 'gorsel', 'sira', 'durum', 'meta_title', 'meta_desc'];

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
