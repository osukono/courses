<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use App\PlayerSettings;
use Illuminate\Support\Arr;

class FirebasePlayerSettingsRepository
{
    public const pause_after_exercise = 'pause_after_exercise';
    public const pause_between = 'pause_between';
    public const pause_practise_1 = 'pause_practise_1';
    public const pause_practise_2 = 'pause_practise_2';
    public const pause_practise_3 = 'pause_practise_3';

    /**
     * @param Language $language
     */
    public static function sync(Language $language)
    {
        if ($language->playerSettings()->exists()) {
            FirebasePlayerSettingsRepository::save($language);
        } else {
            FirebasePlayerSettingsRepository::load($language);
        }
    }

    /**
     * @param Language $language
     */
    private static function save(Language $language)
    {
        $playerSettings = $language->playerSettings;

        $firebase = Firebase::getInstance()->firestoreClient();

        $languageReference = $firebase->collection(Firebase::languages_collection)
            ->document($language->firebase_id);

        $languageReference->set([
            self::pause_after_exercise => $playerSettings->pause_after_exercise,
            self::pause_between => $playerSettings->pause_between,
            self::pause_practise_1 => $playerSettings->pause_practice_1,
            self::pause_practise_2 => $playerSettings->pause_practice_2,
            self::pause_practise_3 => $playerSettings->pause_practice_3
        ], ['merge' => true]);
    }

    /**
     * @param Language $language
     */
    private static function load(Language $language)
    {
        $firebase = Firebase::getInstance()->firestoreClient();

        $languageSnapshot = $firebase->collection(Firebase::languages_collection)
            ->document($language->firebase_id)->snapshot();

        if (Arr::has($languageSnapshot->data(), [
            self::pause_after_exercise,
            self::pause_between,
            self::pause_practise_1,
            self::pause_practise_2,
            self::pause_practise_3
        ])) {
            $playerSettings = new PlayerSettings();
            $playerSettings->language()->associate($language);

            $playerSettings->pause_after_exercise = $languageSnapshot->get(self::pause_after_exercise);
            $playerSettings->pause_between = $languageSnapshot->get(self::pause_between);
            $playerSettings->pause_practice_1 = $languageSnapshot->get(self::pause_practise_1);
            $playerSettings->pause_practice_2 = $languageSnapshot->get(self::pause_practise_2);
            $playerSettings->pause_practice_3 = $languageSnapshot->get(self::pause_practise_3);

            $playerSettings->save();
        }
    }
}
