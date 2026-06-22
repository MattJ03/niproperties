<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder {

    public function run() {

        $role1 = Role::create(['name' => 'landlord']);
        $role2 = Role::create(['name' => 'buyer']);

        $permission1 = Permission::create(['name' => 'list property']);
        $permission2 = Permission::create(['name' => 'edit property']);
        $permission3 = Permission::create(['name' => 'delete property']);
        $permission4 = Permission::create(['name' => 'accept property offer']);
        $permission5 = Permission::create(['name' => 'reject property offer']);
        $permission6 = Permission::create(['name' => 'favourite property']);

        $role1->givePermissionTo($permission1, $permission2, $permission3, $permission4, $permission5, $permission6);

    }
}
