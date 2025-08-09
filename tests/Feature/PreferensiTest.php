<?php

namespace Tests\Feature;

use App\Models\Criteria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreferensiTest extends TestCase
{
    use RefreshDatabase;
    public function test_preferensi_store_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // Autentikasi
        $criteria = Criteria::factory()->count(3)->create();
        $matriksManual = [
            [
                'criteria_id_first' => $criteria[0]->id,
                'criteria_id_second' => $criteria[1]->id,
                'nilai' => 3,
            ],
            [
                'criteria_id_first' => $criteria[0]->id,
                'criteria_id_second' => $criteria[2]->id,
                'nilai' => 5,
            ],
            [
                'criteria_id_first' => $criteria[1]->id,
                'criteria_id_second' => $criteria[2]->id,
                'nilai' => 2,
            ],
        ];
        $response = $this->postJson(route('preferensi.store'), [
            'matriks_manual_fill' => $matriksManual,
            'matriks_auto_fill' => [],
        ]);
        dd($response);
        $response->assertStatus(200)
                 ->assertJson(['status' => true]);

        $this->assertDatabaseCount('criteria_comparisons', 6); // 3 input + 3 hasil autofill (asumsi simetris)
        $this->assertDatabaseHas('criteria_weights', [
            'user_id' => $user->id,
        ]);
    }

    public function test_preferensi_store_failed_due_to_invalid_value()
    {
        $criteria = Criteria::factory()->count(2)->create();

        $invalidManual = [
            [
                'criteria_id_first' => $criteria[0]->id,
                'criteria_id_second' => $criteria[1]->id,
                'nilai' => 999, // nilai tidak termasuk dalam skala Saaty
            ]
        ];

        $response = $this->postJson(route('preferensi.store'), [
            'matriks_manual_fill' => $invalidManual,
            'matriks_auto_fill' => [],
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => false,
                 ]);

        $this->assertDatabaseCount('criteria_comparisons', 0);
        $this->assertDatabaseCount('criteria_weights', 0);
    }
}
