<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder {

    public function run() {

        $role1 = Role::firstOrCreate(['name' => 'landlord']);
        $role2 = Role::firstOrCreate(['name' => 'buyer']);

        $permission1 = Permission::firstOrCreate(['name' => 'list property']);
        $permission2 = Permission::firstOrCreate(['name' => 'edit property']);
        $permission3 = Permission::firstOrCreate(['name' => 'delete property']);
        $permission4 = Permission::firstOrCreate(['name' => 'accept property offer']);
        $permission5 = Permission::firstOrCreate(['name' => 'reject property offer']);
        $permission6 = Permission::firstOrCreate(['name' => 'favourite property']);
        $permission7 = Permission::firstOrCreate(['name' => 'make an offer']);

        $role1->givePermissionTo($permission1, $permission2, $permission3, $permission4, $permission5, $permission6, $permission7);
        $role2->givePermissionTo($permission6, $permission7);
    }
}
