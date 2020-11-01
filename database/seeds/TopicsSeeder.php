<?php

namespace Database\Seeders;

use App\Topic;
use Illuminate\Database\Seeder;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Topic(['identifier' => 'grammar', 'name' => 'Grammar']))->save();
        (new Topic(['identifier' => 'travelling', 'name' => 'Travelling']))->save();
    }
}
