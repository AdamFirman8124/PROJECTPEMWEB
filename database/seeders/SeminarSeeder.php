<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seminar;
use Faker\Factory as Faker;

class SeminarSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Seminar::create([
                'tanggal_seminar' => $faker->date(),
                'lokasi_seminar' => $faker->city,
                'google_map_link' => $faker->url,
                'gambar_seminar' => 'https://picsum.photos/640/480?random=' . $i, // Menggunakan Lorem Picsum untuk gambar acak
                'is_paid' => $faker->boolean,
                'start_registration' => $faker->dateTimeBetween('-1 month', 'now'),
                'end_registration' => $faker->dateTimeBetween('now', '+1 month'),
                'pembicara' => $faker->name,
                'asal_instansi' => $faker->company,
                'topik' => $faker->sentence,
                'materi' => $faker->randomElement([null, $faker->url])
            ]);
        }
    }
}