<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Criteria>
 */
class CriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => 'C' . fake()->randomNumber(),
            'name' => fake()->name(),
            'tipe' => fake()->randomElement(['cost', 'benefit']),
            'atribut' => fake()->randomElement(['dinamis', 'konstanta']),
            'is_include' => true,
        ];
    }
}
