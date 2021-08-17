<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'productType-list',
           'productType-create',
           'productType-edit',
           'productType-delete',
           'productCategory-list',
           'productCategory-create',
           'productCategory-edit',
           'productCategory-delete',
           'productPlatform-list',
           'productPlatform-create',
           'productPlatform-edit',
           'productPlatform-delete',
           'contact-list',
           'review-list',
           'review-create',
           'review-edit',
           'review-delete',
           'faq-list',
           'faq-create',
           'faq-edit',
           'faq-delete'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
