<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsSeeder extends Seeder
{
    private $levels = [
        ['scale' => 'A0', 'name' => 'Beginner'],
        ['scale' => 'A1', 'name' => 'Elementary'],
        ['scale' => 'A2', 'name' => 'Pre-Intermediate'],
        ['scale' => 'B1', 'name' => 'Intermediate'],
        ['scale' => 'B2', 'name' => 'Upper Intermediate'],
        ['scale' => 'C1', 'name' => 'Advanced'],
        ['scale' => 'C2', 'name' => 'Proficiency']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->levels as $level)
            DB::table('levels')->insert([
                'scale' => $level['scale'],
                'name' => $level['name']
            ]);
    }
}
