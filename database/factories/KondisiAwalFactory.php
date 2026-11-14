<?php

namespace Database\Factories;

use App\Models\KondisiAwal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\KondisiAwal>
 */
class KondisiAwalFactory extends Factory
{
    public function definition(): array
    {
        return [
            // koleksi_pita_id diisi otomatis lewat relasi ($koleksi->kondisiAwal()->create(...)).
            'tingkat_kerusakan' => fake()->randomElement(KondisiAwal::TINGKAT),
            'ada_jamur' => fake()->boolean(25),
            'sticky_shed' => fake()->boolean(30),
            'tanggal_periksa' => fake()->dateTimeBetween('-1 year')->format('Y-m-d'),
            'catatan' => fake()->sentence(8),
        ];
    }
}
