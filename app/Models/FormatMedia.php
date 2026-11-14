<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormatMedia extends Model
{
    protected $table = 'format_media';

    protected $fillable = ['kode', 'nama', 'keterangan'];

    public function koleksiPitas(): HasMany
    {
        return $this->hasMany(KoleksiPita::class, 'format_media_id');
    }
}
