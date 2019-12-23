<?php

use App\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Language(['name' => 'Russian', 'code' => 'ru']))->save();
        (new Language(['name' => 'English (US)', 'code' => 'en-US']))->save();
    }
}
