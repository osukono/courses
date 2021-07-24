<?php


namespace App\Repositories;


use App\Language;
use App\Lesson;
use App\LessonAsset;
use App\Library\Firebase;
use App\Library\StrUtils;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LessonAssetRepository
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

        $asset = self::getOrCreate($lesson, $language);
        $asset->image = $image;
        $asset->save();
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @return mixed|string|null
     */
    public static function getImage(Lesson $lesson, Language $language) {
        $asset = self::getOrCreate($lesson, $language);
        return $asset->image;
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     */
    public static function deleteImage(Lesson $lesson, Language  $language) {
        $asset = self::getOrCreate($lesson, $language);
        $asset->image = null;
        $asset->save();
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @return mixed|string|null
     */
    public static function getGrammarPoint(Lesson $lesson, Language $language) {
        $asset = self::getOrCreate($lesson, $language);
        return $asset->grammar_point;
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @param Request $request
     */
    public static function updateGrammarPoint(Lesson $lesson, Language $language, Request $request) {
        $asset = self::getOrCreate($lesson, $language);

        $grammar_point = StrUtils::deleteBetween('<p data-f-id="pbf"', '</p>', $request['grammar_point']);

        $asset->grammar_point = $grammar_point == '' ? null : $grammar_point;
        $asset->save();
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @return mixed|string|null
     */
    public static function getDescription(Lesson $lesson, Language $language) {
        $asset = self::getOrCreate($lesson, $language);
        return $asset->description;
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @param Request $request
     */
    public static function updateDescription(Lesson $lesson, Language $language, Request $request) {
        $asset = self::getOrCreate($lesson, $language);

        $asset->description = $request['description'];
        $asset->save();
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @return LessonAsset|Model
     */
    public static function getOrCreate(Lesson $lesson, Language $language) {
        return LessonAsset::firstOrCreate([
            'lesson_id' => $lesson->id,
            'language_id' => $language->id,
        ]);
    }
}
