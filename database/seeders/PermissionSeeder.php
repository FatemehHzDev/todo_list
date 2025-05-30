<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);

        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('edit articles');
        $role2->givePermissionTo('delete articles');
        $role3 = Role::create(['name' => 'Super-Admin']);

        $user=User::create([
            'name'=>'ali',
            'mobile'=>'09111111111',
            'password'=>'123456789'

            ]);
        $user->assignRole($role1);

        $user=User::create([
            'name'=>'sara',
            'mobile'=>'09222222222',
            'password'=>'123456789'

        ]);
        $user->assignRole($role2);
        $user=User::create([
            'name'=>'amir',
            'mobile'=>'09333333333',
            'password'=>'123456789'

        ]);
        $user->assignRole($role3);

    }
}
