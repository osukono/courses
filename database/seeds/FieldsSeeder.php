<?php

use App\DataType;
use App\Field;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text = DB::table('data_types')->insertGetId(['type' => DataType::text]);
        $string = DB::table('data_types')->insertGetId(['type' => DataType::string]);
        $audio = DB::table('data_types')->insertGetId(['type' => DataType::audio]);
        $picture = DB::table('data_types')->insertGetId(['type' => DataType::picture]);

        $translation = new Field();
        $translation->dataType()->associate($string);
        $translation->name = 'Translation';
        $translation->identifier = 'translation';
        $translation->translatable = true;
        $translation->audible = true;
        $translation->save();

        $context = new Field();
        $context->dataType()->associate($string);
        $context->name = 'Context';
        $context->identifier = 'context';
        $context->translatable = false;
        $context->audible = true;
        $context->save();

        $reading = new Field();
        $reading->dataType()->associate($text);
        $reading->name = 'Reqding';
        $reading->identifier = 'reading';
        $reading->translatable = false;
        $reading->audible = false;
    }
}
