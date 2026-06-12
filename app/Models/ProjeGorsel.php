<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjeGorsel extends Model
{
    protected $table = 'proje_gorselleri';

    protected $fillable = ['proje_id', 'yol', 'alt_metin', 'sira'];

    public function proje(): BelongsTo
    {
        return $this->belongsTo(Proje::class, 'proje_id');
    }
}
