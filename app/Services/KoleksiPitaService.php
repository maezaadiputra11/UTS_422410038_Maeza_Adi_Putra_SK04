<?php

namespace App\Services;

use App\Models\KoleksiPita;
use App\Models\TindakanRestorasi;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Service untuk operasi multi-tabel koleksi.
 * Tiga write (koleksi, kondisi awal, pivot tindakan) dijalankan dalam SATU transaksi:
 * jika salah satu gagal, semuanya di-rollback.
 */
class KoleksiPitaService
{
    public function simpan(array $data, ?KoleksiPita $koleksi = null): KoleksiPita
    {
        return DB::transaction(function () use ($data, $koleksi) {
            $atribut = Arr::only($data, [
                'format_media_id', 'kode', 'nama', 'tahun_rekaman', 'deskripsi',
            ]);

            if ($koleksi) {
                $koleksi->update($atribut);
            } else {
                $koleksi = KoleksiPita::create($atribut);
            }

            // One-to-One
            $kondisi = $data['kondisi'] ?? [];
            $koleksi->kondisiAwal()->updateOrCreate(
                ['koleksi_pita_id' => $koleksi->id],
                [
                    'tingkat_kerusakan' => $kondisi['tingkat_kerusakan'],
                    'ada_jamur' => (bool) ($kondisi['ada_jamur'] ?? false),
                    'sticky_shed' => (bool) ($kondisi['sticky_shed'] ?? false),
                    'tanggal_periksa' => $kondisi['tanggal_periksa'] ?? null,
                    'catatan' => $kondisi['catatan'] ?? null,
                ]
            );

            // Many-to-Many + atribut pivot
            $koleksi->tindakanRestorasis()->sync($this->susunPivot($data['tindakan'] ?? []));

            return $koleksi->load(['formatMedia', 'kondisiAwal', 'tindakanRestorasis']);
        });
    }

    /**
     * Ubah input form tindakan[ID][aktif|prioritas|status] menjadi array siap sync():
     * [id => ['prioritas' => .., 'status' => ..]]. Hanya baris yang dicentang yang dipakai,
     * dan ID dicocokkan dengan master agar tidak melanggar foreign key.
     */
    private function susunPivot(array $tindakan): array
    {
        $idValid = TindakanRestorasi::whereIn('id', array_keys($tindakan))->pluck('id')->all();

        $hasil = [];
        foreach ($tindakan as $id => $baris) {
            if (empty($baris['aktif']) || ! in_array((int) $id, $idValid, true)) {
                continue;
            }

            $hasil[(int) $id] = [
                'prioritas' => (int) ($baris['prioritas'] ?? 3),
                'status' => $baris['status'] ?? 'rencana',
            ];
        }

        return $hasil;
    }
}
