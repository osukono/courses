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
        (new Language(['name' => 'Russian', 'native' => 'Русский', 'code' => 'ru-RU']))->save();
        (new Language(['name' => 'English (US)', 'native' => 'English US', 'code' => 'en-US']))->save();
        (new Language(['name' => 'Ukrainian', 'native' => 'Українська', 'code' => 'uk-UA']))->save();
    }
}
