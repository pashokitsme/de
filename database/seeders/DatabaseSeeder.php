<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('bookworm'),
            'is_admin' => true,
            'email_verified_at' => now(),
            'phone' => '+7 (999) 999-99-99'
        ]);
    }
}
