<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KoleksiPita extends Model
{
    use HasFactory;

    protected $table = 'koleksi_pitas';

    protected $fillable = [
        'format_media_id',
        'kode',
        'nama',
        'tahun_rekaman',
        'deskripsi',
    ];

    /* ---------------- Relasi ---------------- */

    // One-to-Many (sisi many)
    public function formatMedia(): BelongsTo
    {
        return $this->belongsTo(FormatMedia::class, 'format_media_id');
    }

    // One-to-One
    public function kondisiAwal(): HasOne
    {
        return $this->hasOne(KondisiAwal::class, 'koleksi_pita_id');
    }

    // Many-to-Many melalui pivot koleksi_tindakan
    public function tindakanRestorasis(): BelongsToMany
    {
        return $this->belongsToMany(
            TindakanRestorasi::class,
            'koleksi_tindakan',
            'koleksi_pita_id',
            'tindakan_restorasi_id'
        )
            ->withPivot(['prioritas', 'status'])
            ->withTimestamps();
    }

    /* ---------------- Mutator ---------------- */

    protected function kode(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value))
        );
    }

    protected function nama(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => trim($value)
        );
    }

    /* ---------------- Local scope (pencarian & filter) ---------------- */

    public function scopeSearch(Builder $query, ?string $keyword): void
    {
        $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('kode', 'like', "%{$keyword}%")
                    ->orWhere('nama', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeFormat(Builder $query, ?int $formatMediaId): void
    {
        $query->when($formatMediaId, fn ($q, $id) => $q->where('format_media_id', $id));
    }

    public function scopeKerusakan(Builder $query, ?string $tingkat): void
    {
        $query->when($tingkat, function ($q, $tingkat) {
            $q->whereHas('kondisiAwal', fn ($k) => $k->where('tingkat_kerusakan', $tingkat));
        });
    }

    public function scopeTindakan(Builder $query, ?int $tindakanId): void
    {
        $query->when($tindakanId, function ($q, $id) {
            $q->whereHas('tindakanRestorasis', fn ($t) => $t->where('tindakan_restorasis.id', $id));
        });
    }
}
