<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'James Wilton',
            'email' => 'test@example.com',
            'username' => 'jameswilton',
            'location' => 'Indonesia',
            'bio' => "Halo nama saya adalah James Wilton. Ini adalah profil saya",
            'password' => Hash::make('test')
        ]);
    }
}
