<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
    protected $fillable = [
        'type', 'media_path', 'thumbnail_path', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /** Sadece aktif vitrin kayıtları. */
    public function scopeAktif(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    /** order sütununa göre sıralı. */
    public function scopeSirali(Builder $q): Builder
    {
        return $q->orderBy('order')->orderBy('id');
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /**
     * Vitrin kartında/lightbox kapağında gösterilecek görsel yolu.
     * Video ise zorunlu kapak (thumbnail), görsel ise medyanın kendisi.
     */
    public function getKapakAttribute(): ?string
    {
        return $this->isVideo() ? $this->thumbnail_path : $this->media_path;
    }
}
