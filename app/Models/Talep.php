<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Talep extends Model
{
    protected $table = 'talepler';

    protected $fillable = [
        'ad', 'telefon', 'email', 'il_ilce', 'ilgi_alani', 'urun_id',
        'm2', 'mesaj', 'foto', 'kvkk_onay', 'durum', 'kaynak',
    ];

    protected $casts = [
        'kvkk_onay' => 'boolean',
    ];

    public const DURUMLAR = [
        'yeni'        => 'Yeni',
        'okundu'      => 'Okundu',
        'arandi'      => 'Arandı',
        'sonuclandi'  => 'Sonuçlandı',
    ];

    public function urun(): BelongsTo
    {
        return $this->belongsTo(Urun::class, 'urun_id');
    }
}
