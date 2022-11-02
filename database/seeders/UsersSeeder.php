<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'user'];
        foreach ($roles as $role){
            \Spatie\Permission\Models\Role::create([
                'name' => $role
            ]);
        }

        $user = User::create([
            'name' => 'Abdul Majeed Shehzad',
            'email' => 'user@system.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(2);

        $admin = User::create([
            'name' => 'Dor Sarig',
            'email' => 'admin@system.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole(1);
    }
}
