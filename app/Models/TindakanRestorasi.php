<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TindakanRestorasi extends Model
{
    protected $table = 'tindakan_restorasis';

    protected $fillable = ['nama', 'deskripsi', 'estimasi_jam', 'aktif'];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function koleksiPitas(): BelongsToMany
    {
        return $this->belongsToMany(
            KoleksiPita::class,
            'koleksi_tindakan',
            'tindakan_restorasi_id',
            'koleksi_pita_id'
        )
            ->withPivot(['prioritas', 'status'])
            ->withTimestamps();
    }
}
