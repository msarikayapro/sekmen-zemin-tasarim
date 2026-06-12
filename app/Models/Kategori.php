<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    protected $table = 'kategoriler';

    protected $fillable = ['ad', 'slug', 'gorsel', 'aciklama_seo', 'sira'];

    public function urunler(): BelongsToMany
    {
        return $this->belongsToMany(Urun::class, 'urun_kategori', 'kategori_id', 'urun_id');
    }

    public function yayindaUrunler(): BelongsToMany
    {
        return $this->urunler()->where('durum', 'yayin');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
