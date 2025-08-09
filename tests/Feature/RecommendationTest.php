<?php

namespace Tests\Feature;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\PerformanceRating;
use App\Models\SubCriteria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RecommendationTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_dapat_mengakses_rekomendasi_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $criteria = Criteria::factory()->create([
            'name' => 'Kebersihan',
            'is_include' => true
        ]);
        $sub = SubCriteria::factory()->create([
            'criteria_id' => $criteria->id,
            'bobot' => 4
        ]);
        $alt = Alternative::factory()->create([
            'status' => 'accepted',
            'maps_lokasi' => '0.293,101.712' // format valid
        ]);
        PerformanceRating::factory()->create([
            'alternative_id' => $alt->id,
            'criteria_id' => $criteria->id,
            'sub_criteria_id' => $sub->id
        ]);
        DB::table('criteria_weights')->insert([
            'criteria_id' => $criteria->id,
            'user_id' => $user->id,
            'bobot' => 0.7,
            'total' => 5
        ]);
        $payload = [
            'lokasi_user' => '0.292,101.713',
            'kriteria_id' => [$criteria->id],
            'sub_criteria_id' => [$sub->id]
        ];
        $response = $this->post(route('spk/destinasi/rekomendasi.store'), $payload);
        $response->assertRedirect();
    }
}
