<?php

namespace Tests\Feature;

use App\Models\Criteria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CriteriaTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_criteria()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);
        // Payload data yang valid
        $data = [
            'name' => 'Kebersihan',
            'type' => 'benefit',
            'bobot' => 30,
            'is_include' => true,
        ];
        $response = $this->post(route('spk/destinasi/kriteria.store'), $data);
        $response->assertRedirect(route('spk/destinasi/kriteria.index'));
        $this->assertDatabaseHas('criterias', ['name' => 'Kebersihan']);
    }

    public function test_toogle_activated_criteria()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);
        // Buat kriteria awal dengan is_include = true
        $criteria = Criteria::factory()->create();
        // Encrypt ID
        $encryptedId = encrypt($criteria->id);
        // Aksi: toggle jadi false
        $response = $this->put(route('spk/destinasi/kriteria.activated', $encryptedId));
        $response->assertRedirect();
        $this->assertDatabaseHas('criterias', [
            'id' => $criteria->id,
            'is_include' => false,
        ]);
        // Aksi lagi: toggle jadi true
        $response = $this->put(route('spk/destinasi/kriteria.activated', $encryptedId));
        $response->assertRedirect();
        $this->assertDatabaseHas('criterias', [
            'id' => $criteria->id,
            'is_include' => true,
        ]);
    }
}
