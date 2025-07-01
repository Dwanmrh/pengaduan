<?php

namespace Database\Factories;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengaduanFactory extends Factory
{
    protected $model = Pengaduan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'judul' => $this->faker->sentence,
            'isi_pengaduan' => $this->faker->paragraph,
            'bagian' => $this->faker->randomElement(['Sarana', 'Akademik', 'Keuangan']),
            'lampiran' => null,
            'status' => 'menunggu',
        ];
    }
}
