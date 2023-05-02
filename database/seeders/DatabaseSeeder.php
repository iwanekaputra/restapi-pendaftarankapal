<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $role1 = Role::create([
            'name' => 'user'
        ]);
        $role2 = Role::create([
            'name' => 'admin'
        ]);

        $permission1 = Permission::create([
            'name' => 'create kapal',
        ]);
        $permission2 = Permission::create([
            'name' => 'update kapal',
        ]);
        $permission3 = Permission::create([
            'name' => 'delete kapal',
        ]);

        $user->assignRole('user');
        $admin->assignRole('admin');

        $role1->givePermissionTo([$permission1, $permission2]);
        $role2->givePermissionTo([$permission1, $permission2, $permission3]);

    }
}
