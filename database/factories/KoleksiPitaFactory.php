<?php

namespace Database\Factories;

use App\Models\FormatMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\KoleksiPita>
 */
class KoleksiPitaFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Format dipilih dari master yang sudah di-seed (FormatMediaSeeder harus jalan lebih dulu).
            'format_media_id' => FormatMedia::query()->inRandomOrder()->value('id'),
            'kode' => 'PTA-'.fake()->unique()->numerify('####'),
            'nama' => fake()->randomElement([
                'Arsip Siaran Radio',
                'Rekaman Wawancara',
                'Konser Lokal',
                'Pidato Tokoh',
                'Musik Keroncong',
                'Rekaman Lapangan',
            ]).' Vol. '.fake()->numberBetween(1, 99),
            'tahun_rekaman' => fake()->numberBetween(1960, 1999),
            'deskripsi' => fake()->sentence(12),
        ];
    }
}
