<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan penting: master (parent) dulu, baru data yang memakai foreign key.
     */
    public function run(): void
    {
        $this->call([
            FormatMediaSeeder::class,
            TindakanRestorasiSeeder::class,
            KoleksiPitaSeeder::class,
        ]);
    }
}
