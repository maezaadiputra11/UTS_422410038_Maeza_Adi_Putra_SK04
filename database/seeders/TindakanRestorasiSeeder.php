<?php

namespace Database\Seeders;

use App\Models\TindakanRestorasi;
use Illuminate\Database\Seeder;

class TindakanRestorasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pembersihan permukaan pita', 'estimasi_jam' => 2, 'deskripsi' => 'Membersihkan debu dan kotoran dari permukaan pita.'],
            ['nama' => 'Baking (dehidrasi pita)', 'estimasi_jam' => 8, 'deskripsi' => 'Memanaskan pita terkontrol untuk mengatasi sticky-shed.'],
            ['nama' => 'Splicing sambungan putus', 'estimasi_jam' => 1, 'deskripsi' => 'Menyambung kembali pita yang putus.'],
            ['nama' => 'Penggantian leader', 'estimasi_jam' => 1, 'deskripsi' => 'Mengganti leader tape yang rapuh.'],
            ['nama' => 'Penggantian shell kaset', 'estimasi_jam' => 2, 'deskripsi' => 'Memindahkan gulungan ke shell baru.'],
            ['nama' => 'Perawatan jamur', 'estimasi_jam' => 4, 'deskripsi' => 'Membersihkan dan menangani pita berjamur.'],
            ['nama' => 'Digitalisasi arsip', 'estimasi_jam' => 6, 'deskripsi' => 'Alih media ke format digital.'],
            ['nama' => 'Pengemasan ulang dan penyimpanan', 'estimasi_jam' => 1, 'deskripsi' => 'Kemasan arsip dan penyimpanan terkontrol.'],
        ];

        foreach ($data as $row) {
            TindakanRestorasi::updateOrCreate(['nama' => $row['nama']], $row + ['aktif' => true]);
        }
    }
}
