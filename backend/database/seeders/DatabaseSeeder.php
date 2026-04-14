<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name_en' => 'Test User',
            'name_ar' => 'مستخدم تجريبي',
            'email' => 'test@example.com',
        ]);

        User::factory(1000)->create();


        $this->call([
            PermissionSeeder::class,
        ]);

        $superAdminRole = Role::create([
            'name_en' => 'Super Admin',
            'name_ar' => 'المسؤول العام',
        ]);

        $superAdminRole->permissions()->sync(Permission::pluck('id')->toArray());

        $user = User::find(1);
        $user->roles()->sync([$superAdminRole->id]);


    }
}
