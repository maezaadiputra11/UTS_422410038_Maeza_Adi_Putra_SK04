<?php

namespace Database\Seeders;

use App\Models\KoleksiPita;
use App\Models\KondisiAwal;
use App\Models\TindakanRestorasi;
use Illuminate\Database\Seeder;

class KoleksiPitaSeeder extends Seeder
{
    public function run(): void
    {
        $tindakanIds = TindakanRestorasi::pluck('id');

        KoleksiPita::factory()->count(15)->create()->each(function (KoleksiPita $koleksi) use ($tindakanIds) {
            // One-to-One: satu detail kondisi awal per koleksi
            $koleksi->kondisiAwal()->create(KondisiAwal::factory()->make()->toArray());

            // Many-to-Many: 1-3 tindakan restorasi per koleksi
            $pilihan = $tindakanIds->random(random_int(1, 3))->mapWithKeys(fn ($id) => [
                $id => [
                    'prioritas' => random_int(1, 5),
                    'status' => collect(['rencana', 'berjalan', 'selesai'])->random(),
                ],
            ]);

            $koleksi->tindakanRestorasis()->attach($pilihan->all());
        });
    }
}
