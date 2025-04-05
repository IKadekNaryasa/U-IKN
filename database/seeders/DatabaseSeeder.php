<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        User::factory(2)->unverified()->create();
        User::factory(1)->head()->create();
        // User::factory(2)->loggedIn()->create();

        User::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Chitos',
            'email' => 'chitos@gmail.com',
            'username' => 'chitos.ikn',
            'password' => Hash::make('12345678'),
            'password_updated_at' => now(),
            'logged_in' => false,
            'status' => 'active',
            'role' => 'admin',
            'contact' => '087864365344',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
