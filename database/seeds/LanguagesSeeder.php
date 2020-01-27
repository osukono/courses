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
        (new Language(['name' => 'Russian', 'code' => 'ru-RU']))->save();
        (new Language(['name' => 'English (US)', 'code' => 'en-US']))->save();
        (new Language(['name' => 'Ukrainian', 'code' => 'uk-UA']))->save();
    }
}
