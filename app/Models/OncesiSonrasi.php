<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OncesiSonrasi extends Model
{
    protected $table = 'oncesi_sonrasi';

    protected $fillable = ['baslik', 'oncesi_gorsel', 'sonrasi_gorsel', 'proje_id', 'sira', 'durum'];

    public function proje(): BelongsTo
    {
        return $this->belongsTo(Proje::class, 'proje_id');
    }

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }
}
