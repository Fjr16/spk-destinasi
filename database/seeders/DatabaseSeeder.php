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

        if (!DB::table('criterias')->where('name', 'Jarak Tempuh')->exists()) {
            DB::table('criterias')->insert([
                [
                    'kode' => 'C1',
                    'name' => 'Jarak Tempuh',
                    'tipe' => 'cost',
                    'jenis' => 'kuantitatif',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C2',
                    'name' => 'Harga',
                    'tipe' => 'cost',
                    'jenis' => 'kuantitatif',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C3',
                    'name' => 'Aksesibilitas',
                    'tipe' => 'benefit',
                    'jenis' => 'kualitatif',
                    'is_include' => true,
                ],
                [
                    'kode' => 'C4',
                    'name' => 'Fasilitas',
                    'tipe' => 'benefit',
                    'jenis' => 'kualitatif',
                    'is_include' => true,
                ],
            ]);
        }

        // DB::table('users')->insert([
        //     'name' => 'Admin',
        //     'username' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin123'),
        //     'role' => 'Administrator',
        // ]);
    }
}
