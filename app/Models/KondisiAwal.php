<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KondisiAwal extends Model
{
    use HasFactory;

    public const TINGKAT = ['ringan', 'sedang', 'berat'];

    protected $table = 'kondisi_awals';

    protected $fillable = [
        'koleksi_pita_id',
        'tingkat_kerusakan',
        'ada_jamur',
        'sticky_shed',
        'tanggal_periksa',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'ada_jamur' => 'boolean',
            'sticky_shed' => 'boolean',
            'tanggal_periksa' => 'date',
        ];
    }

    public function koleksiPita(): BelongsTo
    {
        return $this->belongsTo(KoleksiPita::class, 'koleksi_pita_id');
    }

    // Accessor: varian warna badge berdasarkan tingkat kerusakan
    protected function warnaKerusakan(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->tingkat_kerusakan) {
                'berat' => 'danger',
                'sedang' => 'warning',
                default => 'success',
            }
        );
    }
}
