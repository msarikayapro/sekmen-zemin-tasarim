<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proje extends Model
{
    protected $table = 'projeler';

    protected $fillable = [
        'baslik', 'slug', 'tip', 'konum', 'tarih', 'aciklama', 'kapak_gorsel',
        'video_url', 'musteri_adi', 'musteri_yorumu', 'one_cikan', 'sira', 'durum',
    ];

    protected $casts = [
        'one_cikan' => 'boolean',
    ];

    public const TIPLER = [
        'konut'  => 'Konut',
        'kamu'   => 'Kamu',
        'ticari' => 'Ticari',
        'peyzaj' => 'Peyzaj',
    ];

    public function gorseller(): HasMany
    {
        return $this->hasMany(ProjeGorsel::class, 'proje_id')->orderBy('sira');
    }

    public function urunler(): BelongsToMany
    {
        return $this->belongsToMany(Urun::class, 'proje_urun', 'proje_id', 'urun_id');
    }

    public function oncesiSonrasi(): HasMany
    {
        return $this->hasMany(OncesiSonrasi::class, 'proje_id');
    }

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira')->orderByDesc('id');
    }

    public function getKapakAttribute($value): ?string
    {
        return $this->kapak_gorsel ?: optional($this->gorseller->first())->yol;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
