<?php

use App\Library\Permissions;
use App\Library\Roles;
use App\User;
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
        $admin = new User();
        $admin->name = 'osukono';
        $admin->email = 'osukono@gmail.com';
        $admin->password = bcrypt('osukono');
        $admin->save();
        $admin->assignRole(Roles::admin);
    }
}
