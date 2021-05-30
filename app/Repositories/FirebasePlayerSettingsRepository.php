<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use App\PlayerSettings;
use Illuminate\Support\Arr;

class FirebasePlayerSettingsRepository
{
    public const pause_after_exercise = 'pause_after_exercise';
    public const listening_rate = 'listening_rate';
    public const practice_rate = 'practice_rate';

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
            self::listening_rate => $playerSettings->listening_rate,
            self::practice_rate => $playerSettings->practice_rate,
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
            self::listening_rate,
            self::practice_rate,
        ])) {
            $playerSettings = new PlayerSettings();
            $playerSettings->language()->associate($language);

            $playerSettings->pause_after_exercise = $languageSnapshot->get(self::pause_after_exercise);
            $playerSettings->listening_rate = $languageSnapshot->get(self::listening_rate);
            $playerSettings->practice_rate = $languageSnapshot->get(self::practice_rate);

            $playerSettings->save();
        }
    }
}
