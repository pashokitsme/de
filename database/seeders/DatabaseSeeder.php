<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Запускаем сидеры
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
        ]);
        
        // Создаем тестового администратора
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ])->roles()->attach(1); // Привязываем роль администратора
        
        // Создаем тестового обычного пользователя
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ])->roles()->attach(2); // Привязываем роль пользователя
    }
}
