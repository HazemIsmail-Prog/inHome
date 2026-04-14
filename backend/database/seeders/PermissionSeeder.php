<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name_en' => 'dashboard_view',
                'name_ar' => 'عرض لوحة التحكم',
            ],
            [
                'name_en' => 'permissions_view',
                'name_ar' => 'عرض الصلاحيات',
            ],
            [
                'name_en' => 'permissions_create',
                'name_ar' => 'إنشاء الصلاحيات',
            ],
            [
                'name_en' => 'permissions_update',
                'name_ar' => 'تحديث الصلاحيات',
            ],
            [
                'name_en' => 'permissions_delete',
                'name_ar' => 'حذف الصلاحيات',
            ],
            [
                'name_en' => 'users_view',
                'name_ar' => 'عرض المستخدمين',
            ],
            [
                'name_en' => 'users_create',
                'name_ar' => 'إنشاء المستخدمين',
            ],
            [
                'name_en' => 'users_update',
                'name_ar' => 'تحديث المستخدمين',
            ],
            [
                'name_en' => 'users_delete',
                'name_ar' => 'حذف المستخدمين',
            ],
            [
                'name_en' => 'roles_view',
                'name_ar' => 'عرض الأدوار',
            ],
            [
                'name_en' => 'roles_create',
                'name_ar' => 'إنشاء الأدوار',
            ],
            [
                'name_en' => 'roles_update',
                'name_ar' => 'تحديث الأدوار',
            ],
            [
                'name_en' => 'roles_delete',
                'name_ar' => 'حذف الأدوار',
            ],

            [
                'name_en' => 'clients_view',
                'name_ar' => 'عرض العملاء',
            ],
            [
                'name_en' => 'clients_create',
                'name_ar' => 'إنشاء العملاء',
            ],
            [
                'name_en' => 'clients_update',
                'name_ar' => 'تحديث العملاء',
            ],
            [
                'name_en' => 'clients_delete',
                'name_ar' => 'حذف العملاء',
            ],
        ];


        Permission::insert($permissions);
        
    }
}
