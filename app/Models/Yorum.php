<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Yorum extends Model
{
    protected $table = 'yorumlar';

    protected $fillable = ['ad', 'unvan', 'icerik', 'puan', 'gorsel', 'one_cikan', 'durum', 'sira'];

    protected $casts = [
        'one_cikan' => 'boolean',
    ];

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira')->orderByDesc('id');
    }
}
