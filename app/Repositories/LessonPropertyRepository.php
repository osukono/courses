<?php


namespace App\Repositories;


use App\Language;
use App\Lesson;
use App\LessonProperty;
use App\Library\Firebase;
use App\Library\StrUtils;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LessonPropertyRepository
{
    /**
     * @param Lesson $lesson
     * @param Language $language
     * @param Request $request
     * @throws FileNotFoundException
     */
    public static function uploadImage(Lesson $lesson, Language $language, Request $request)
    {
        $image = Firebase::getInstance()->uploadFile($request->file('image'), 'courses');

        $lessonProperty = self::getOrCreate($lesson, $language);
        $lessonProperty->image = $image;
        $lessonProperty->save();
    }

    public static function getImage(Lesson $lesson, Language $language) {
        $lessonProperty = self::getOrCreate($lesson, $language);
        return $lessonProperty->image;
    }

    public static function deleteImage(Lesson $lesson, Language  $language) {
        $lessonProperty = self::getOrCreate($lesson, $language);
        $lessonProperty->image = null;
        $lessonProperty->save();
    }

    public static function getGrammarPoint(Lesson $lesson, Language $language) {
        $lessonProperty = self::getOrCreate($lesson, $language);
        return $lessonProperty->grammar_point;
    }

    public static function updateGrammarPoint(Lesson $lesson, Language $language, Request $request) {
        $lessonProperty = self::getOrCreate($lesson, $language);

        $lessonProperty->grammar_point = StrUtils::deleteBetween('<p data-f-id="pbf"', '</p>', $request['grammar_point']);
        $lessonProperty->save();
    }

    public static function getOrCreate(Lesson $lesson, Language $language) {
        $lessonProperty = LessonProperty::whereLessonId($lesson->id)->whereLanguageId($language->id)->first();
        if ($lessonProperty == null) {
            $lessonProperty = new LessonProperty();
            $lessonProperty->lesson()->associate($lesson);
            $lessonProperty->language()->associate($language);
        }
        return $lessonProperty;
    }
}
