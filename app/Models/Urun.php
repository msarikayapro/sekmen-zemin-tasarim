<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;

    protected $table = 'urunler';

    protected $fillable = [
        'ad', 'slug', 'aciklama',
        'ebat_en', 'ebat_boy', 'kalinlik', 'm2_adet', 'palet_bilgi',
        'renk_secenekleri', 'kullanim_alanlari', 'dayanim', 'don_direnci',
        'video_url', 'one_cikan_gorsel', 'one_cikan', 'sira', 'durum',
        'meta_title', 'meta_desc', 'og_image',
    ];

    protected $casts = [
        'renk_secenekleri'  => 'array',
        'kullanim_alanlari' => 'array',
        'one_cikan'         => 'boolean',
    ];

    public function gorseller(): HasMany
    {
        return $this->hasMany(UrunGorsel::class, 'urun_id')->orderBy('sira');
    }

    public function kategoriler(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'urun_kategori', 'urun_id', 'kategori_id');
    }

    public function projeler(): BelongsToMany
    {
        return $this->belongsToMany(Proje::class, 'proje_urun', 'urun_id', 'proje_id');
    }

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira')->orderBy('ad');
    }

    /** Ana görsel: tanımlı one_cikan_gorsel yoksa ilk galeri görseli. */
    public function getKapakAttribute(): ?string
    {
        return $this->one_cikan_gorsel ?: optional($this->gorseller->first())->yol;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
