<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SssSayfa extends Model
{
    protected $table = 'sss_sayfa';
    public $timestamps = false;
    protected $fillable = ['sss_id', 'sayfa_anahtar'];
}
