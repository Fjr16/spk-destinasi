<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->truncate();
        DB::table('travel_categories')->truncate();
        DB::table('criterias')->truncate();
        DB::table('sub_criterias')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'Administrator',
            ],
            [
                'name' => 'ell',
                'username' => 'ell',
                'email' => 'ellipanggabean42@gmail.com',
                'password' => Hash::make('ell12345'),
                'role' => 'Pengelola',
            ],
        ]);

        DB::table('travel_categories')->insert([
            [
                'name' => 'Wisata Bahari',
            ],
            [
                'name' => 'Wisata Budaya',
            ],
            [
                'name' => 'Wisata Ziarah',
            ],
            [
                'name' => 'Wisata Petualangan',
            ],
        ]);

        if (!DB::table('criterias')->where('name', 'Jarak Tempuh')->exists()) {
            $dataCriterias = [
                [
                    'kode' => 'C1',
                    'name' => 'Jarak Tempuh',
                    'tipe' => 'cost',
                    'jenis' => 'kuantitatif',
                    'atribut' => 'konstanta',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C2',
                    'name' => 'Harga',
                    'tipe' => 'cost',
                    'jenis' => 'kuantitatif',
                    'atribut' => 'dinamis',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C3',
                    'name' => 'Aksesibilitas',
                    'tipe' => 'benefit',
                    'jenis' => 'kualitatif',
                    'atribut' => 'dinamis',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C4',
                    'name' => 'Fasilitas',
                    'tipe' => 'benefit',
                    'jenis' => 'kualitatif',
                    'atribut' => 'dinamis',
                    'is_include' => true,
                ],
            ];
            foreach ($dataCriterias as $key => $criteria) {
                $criteria_id = DB::table('criterias')->insertGetId([
                    'kode' => $criteria['kode'],
                    'name' => $criteria['name'],
                    'tipe' => $criteria['tipe'],
                    'jenis' => $criteria['jenis'],
                    'atribut' => $criteria['atribut'],
                    'is_include' => true,
                ]);

                if ($criteria['name'] == 'Jarak Tempuh') {
                    DB::table('sub_criterias')->insert([
                        [
                            'criteria_id' => $criteria_id,
                            'label' => '80-100 km',
                            'min_value' => 80,
                            'max_value' => 100,
                            'bobot' => 1,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => '60-79,5 km',
                            'min_value' => 60,
                            'max_value' => 79.50,
                            'bobot' => 2,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => '30-59 km',
                            'min_value' => 30,
                            'max_value' => 59,
                            'bobot' => 3,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => '0-29 km',
                            'min_value' => 0,
                            'max_value' => 29,
                            'bobot' => 4,
                        ],
                    ]);
                }elseif($criteria['name'] == 'Harga'){
                    DB::table('sub_criterias')->insert([
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Rp. 50.000-60.000',
                            'min_value' => 50000,
                            'max_value' => 60000,
                            'bobot' => 1,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Rp.40.000-49.000',
                            'min_value' => 40000,
                            'max_value' => 49000,
                            'bobot' => 2,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Rp. 20.000-39.000',
                            'min_value' => 20000,
                            'max_value' => 39000,
                            'bobot' => 3,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Rp. 10.000-19.000',
                            'min_value' => 10000,
                            'max_value' => 19000,
                            'bobot' => 4,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Rp. 0 - 9.000',
                            'min_value' => 0,
                            'max_value' => 9000,
                            'bobot' => 5,
                        ],
                    ]);
                }elseif($criteria['name'] == 'Aksesibilitas'){
                    DB::table('sub_criterias')->insert([
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Jalan kaki',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 1,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Jalan kaki dan kendaraan roda 2',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 2,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Jalan Kaki, Kendaraan roda 2, dan kendaraan roda 4',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 3,
                        ],
                    ]);
                }elseif($criteria['name'] == 'Fasilitas'){
                    DB::table('sub_criterias')->insert([
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Parkir gratis',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 1,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Parkir gratis dan musholla',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 2,
                        ],
                        [
                            'criteria_id' => $criteria_id,
                            'label' => 'Parkir gratis, musholla, dan toilet umum',
                            'min_value' => null,
                            'max_value' => null,
                            'bobot' => 3,
                        ],
                    ]);
                }
                
            } 
        }

    }
}
