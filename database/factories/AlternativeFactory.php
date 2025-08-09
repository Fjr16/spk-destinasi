<?php

namespace Database\Factories;

use App\Models\TravelCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alternative>
 */
class AlternativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Resort',
            'travel_category_id' => TravelCategory::factory(), // relasi
            'deskripsi' => $this->faker->paragraph,
            'alamat' => $this->faker->address,
            'harga' => $this->faker->numberBetween(100000, 1000000),
            'maps_lokasi' => $this->faker->latitude . ',' . $this->faker->longitude,
            'foto' => 'default.jpg', // jika tidak diupload
            'fasilitas' => implode(', ', $this->faker->words(3)), // misal: "wifi, kolam, parkir"
            'aksesibilitas' => $this->faker->randomElement(['mudah', 'sedang', 'sulit']),
            'waktu_operasional' => '08:00 - 17:00',
            'status' => $this->faker->randomElement(['denied', 'accepted', 'waiting']),
        ];
    }
}
