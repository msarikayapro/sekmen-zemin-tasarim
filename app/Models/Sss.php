<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sss extends Model
{
    protected $table = 'sss';

    protected $fillable = ['soru', 'cevap', 'kategori', 'sira', 'durum'];

    public const KATEGORILER = ['Genel', 'Kilitli Taş', 'Bordür', 'Döşeme', 'Peyzaj', 'Garanti/Bakım', 'Nakliye'];

    public const SAYFALAR = [
        'ana_sayfa'     => 'Ana Sayfa',
        'urun_kategori' => 'Ürün Kategori',
        'urun_detay'    => 'Ürün Detay',
        'projeler'      => 'Projeler',
        'hizmetler'     => 'Hizmetler',
        'hakkimizda'    => 'Hakkımızda',
        'iletisim'      => 'İletişim',
        'kvkk'          => 'KVKK',
        'cerez'         => 'Çerez',
    ];

    public function sayfalar(): HasMany
    {
        return $this->hasMany(SssSayfa::class, 'sss_id');
    }

    /** Görünür olduğu sayfa anahtarları (boş = tüm sayfalar). */
    public function getSayfaAnahtarlariAttribute(): array
    {
        return $this->sayfalar->pluck('sayfa_anahtar')->all();
    }

    public function scopeYayinda(Builder $q): Builder
    {
        return $q->where('durum', 'yayin');
    }

    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('sira');
    }

    /**
     * Belirli bir sayfada görünen SSS'ler:
     * sss_sayfa'da hiç kaydı yoksa (tüm sayfalar) VEYA bu sayfaya atanmışsa.
     */
    public function scopeSayfada(Builder $q, string $sayfa): Builder
    {
        return $q->where(function (Builder $w) use ($sayfa) {
            $w->whereDoesntHave('sayfalar')
              ->orWhereHas('sayfalar', fn (Builder $s) => $s->where('sayfa_anahtar', $sayfa));
        });
    }
}
