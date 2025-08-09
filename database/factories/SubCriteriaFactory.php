<?php

namespace Database\Factories;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCriteria>
 */
class SubCriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SubCriteria::class;
    public function definition(): array
    {
        return [
            'criteria_id' => Criteria::factory(),
            'label' => fake()->word(),
            'min_value' => 80,
            'max_value' => 100,
            'bobot' => fake()->numberBetween(1,4)
        ];
    }
}
