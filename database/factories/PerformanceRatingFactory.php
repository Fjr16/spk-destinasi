<?php

namespace Database\Factories;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerformanceRating>
 */
class PerformanceRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alternative_id' => Alternative::factory(),
            'criteria_id' => Criteria::factory(),
            'sub_criteria_id' => SubCriteria::factory(),
        ];
    }
}
