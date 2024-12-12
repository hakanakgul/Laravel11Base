<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Roller
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $parentRole = Role::create(['name' => 'parent']);
        $studentRole = Role::create(['name' => 'student']);
        $userRole = Role::create(['name' => 'user']);

        // İzinler (Örnekler - İhtiyaçlarınıza göre genişletin)
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'view student information']);
        Permission::create(['name' => 'view own student information']);
        Permission::create(['name' => 'manage student grades']);

        // Rollere İzinleri Atama
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole->givePermissionTo([
            'manage courses',
            'view student information',
            'manage student grades',
            'view own student information'
        ]);

        $parentRole->givePermissionTo('view own student information');
        $studentRole->givePermissionTo('view own student information');
    }
}
