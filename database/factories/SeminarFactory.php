<?php

namespace Database\Factories;

use App\Models\Seminar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seminar>
 */
class SeminarFactory extends Factory
{
    protected $model = Seminar::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal_seminar' => $this->faker->date(),
            'lokasi_seminar' => $this->faker->city(),
            'google_map_link' => $this->faker->url(),
            'gambar_seminar' => $this->faker->imageUrl(),
            'start_registration' => $this->faker->date(),
            'end_registration' => $this->faker->date(),
            'pembicara' => $this->faker->name(),
            'asal_instansi' => $this->faker->company(),
            'topik' => $this->faker->sentence(),
            'is_paid' => $this->faker->boolean(),
        ];
    }
}
