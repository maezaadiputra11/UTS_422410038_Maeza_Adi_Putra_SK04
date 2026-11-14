<?php

namespace Database\Seeders;

use App\Models\FormatMedia;
use Illuminate\Database\Seeder;

class FormatMediaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'REEL', 'nama' => 'Reel-to-Reel 1/4 inci', 'keterangan' => 'Pita gulungan terbuka untuk rekaman siaran dan studio.'],
            ['kode' => 'CMP', 'nama' => 'Kaset Compact', 'keterangan' => 'Kaset audio standar (Compact Cassette).'],
            ['kode' => 'MIC', 'nama' => 'Microcassette', 'keterangan' => 'Kaset kecil untuk dikte dan wawancara.'],
            ['kode' => '8TR', 'nama' => '8-Track Cartridge', 'keterangan' => 'Kartrid pita endless-loop.'],
            ['kode' => 'VHS', 'nama' => 'VHS', 'keterangan' => 'Pita video analog rumahan.'],
        ];

        foreach ($data as $row) {
            FormatMedia::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
