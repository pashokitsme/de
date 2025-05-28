<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем основные роли
        Role::create([
            'name' => 'admin',
            'description' => 'Администратор системы',
        ]);
        
        Role::create([
            'name' => 'user',
            'description' => 'Обычный пользователь',
        ]);
        
        Role::create([
            'name' => 'manager',
            'description' => 'Менеджер с ограниченными правами',
        ]);
    }
}
