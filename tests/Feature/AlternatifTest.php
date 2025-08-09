<?php

namespace Tests\Feature;

use App\Models\Criteria;
use App\Models\PerformanceRating;
use App\Models\SubCriteria;
use App\Models\TravelCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlternatifTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_success()
    {
        Storage::fake('public');

        $category = TravelCategory::factory()->create();
        $criteria = Criteria::factory()->count(2)->create();
        $subCriterias = $criteria->map(function ($cri) {
            return SubCriteria::factory()->create(['criteria_id' => $cri->id]);
        });

        $this->actingAs(User::factory()->create());
        $this->assertTrue(auth()->check());
        $payload = [
            'name' => 'Pantai Air Manis',
            'harga' => 15000,
            'waktu_operasional' => '08:00 - 17:00',
            'alamat' => 'Padang, Sumatera Barat',
            'aksesibilitas' => 'Mudah dijangkau kendaraan umum',
            'travel_category_id' => $category->id,
            'fasilitas' => 'Parkir, Toilet, Warung',
            'deskripsi' => 'Pantai yang indah dengan batu Malin Kundang',
            'foto' => UploadedFile::fake()->image('pantai.jpg'),
            'maps_lokasi' => 'https://maps.google.com/example',
            'criteria_id' => $criteria->pluck('id')->toArray(),
            'sub_criteria_id' => $subCriterias->pluck('id')->toArray(),
        ];

        $response = $this->post(route('spk/destinasi/alternative.store'), $payload);
        $response->assertRedirect(route('spk/destinasi/alternative.index'));
        $this->assertDatabaseHas('alternatives', [
            'name' => 'Pantai Air Manis',
        ]);
        $this->assertCount(2, PerformanceRating::all());
    }
    
    public function test_store_failed_due_to_validation()
    {
        $this->actingAs(User::factory()->create());
        $this->assertTrue(auth()->check());
        $response = $this->post(route('spk/destinasi/alternative.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'harga',
            'waktu_operasional',
            'alamat',
            'aksesibilitas',
            'travel_category_id',
            'fasilitas',
            'deskripsi',
            'foto',
            'maps_lokasi',
            'criteria_id',
            'sub_criteria_id'
        ]);
    }
}
