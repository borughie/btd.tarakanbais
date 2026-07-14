<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'instansi' => fake()->company(),
            'tujuan' => fake()->sentence(),
            'jumlah_personil' => fake()->numberBetween(1, 10),
            'nama_pic' => fake()->name(),
            'no_hp' => fake()->phoneNumber(),
            'notified' => false,
        ];
    }
}
