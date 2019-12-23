<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(LanguagesSeeder::class);
         $this->call(LevelsSeeder::class);
         $this->call(FieldsSeeder::class);
         $this->call(PermissionsSeeder::class);
         $this->call(RolesSeeder::class);
         $this->call(UsersSeeder::class);
    }
}
