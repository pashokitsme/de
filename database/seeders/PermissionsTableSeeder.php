<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем базовые разрешения
        $createUserPermission = Permission::create([
            'name' => 'create-user',
            'description' => 'Создание пользователей',
        ]);
        
        $editUserPermission = Permission::create([
            'name' => 'edit-user',
            'description' => 'Редактирование пользователей',
        ]);
        
        $deleteUserPermission = Permission::create([
            'name' => 'delete-user',
            'description' => 'Удаление пользователей',
        ]);
        
        $viewDashboardPermission = Permission::create([
            'name' => 'view-dashboard',
            'description' => 'Просмотр панели управления',
        ]);
        
        // Привязываем разрешения к ролям
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $managerRole = Role::where('name', 'manager')->first();
        
        if ($adminRole) {
            $adminRole->permissions()->attach([
                $createUserPermission->id,
                $editUserPermission->id,
                $deleteUserPermission->id,
                $viewDashboardPermission->id
            ]);
        }
        
        if ($managerRole) {
            $managerRole->permissions()->attach([
                $createUserPermission->id,
                $editUserPermission->id,
                $viewDashboardPermission->id
            ]);
        }
        
        if ($userRole) {
            $userRole->permissions()->attach([
                $viewDashboardPermission->id
            ]);
        }
    }
}
