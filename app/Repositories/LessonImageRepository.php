<?php


namespace App\Repositories;


use App\Language;
use App\Lesson;
use App\LessonImage;
use App\Library\Firebase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;

class LessonImageRepository
{
    /**
     * @param Lesson $lesson
     * @param Language $language
     * @param Request $request
     * @throws FileNotFoundException
     */
    public static function upload(Lesson $lesson, Language $language, Request $request)
    {
        $image = Firebase::getInstance()->uploadFile($request->file('image'), 'courses');

        $lessonImage = new LessonImage();
        $lessonImage->lesson()->associate($lesson);
        $lessonImage->language()->associate($language);
        $lessonImage->image = $image;
        $lessonImage->save();
    }
}
