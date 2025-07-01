<?php

namespace Database\Factories;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TanggapanFactory extends Factory
{
    protected $model = Tanggapan::class;

    public function definition(): array
    {
        return [
            'pengaduan_id' => Pengaduan::factory(),
            'isi_tanggapan' => $this->faker->sentence,
            'user_id' => User::factory(),
        ];
    }
}
