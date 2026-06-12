<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrunGorsel extends Model
{
    protected $table = 'urun_gorselleri';

    protected $fillable = ['urun_id', 'yol', 'alt_metin', 'sira'];

    public function urun(): BelongsTo
    {
        return $this->belongsTo(Urun::class, 'urun_id');
    }
}
