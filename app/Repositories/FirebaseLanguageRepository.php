<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use Exception;
use Kreait\Firebase\Exception\RemoteConfigException;

class FirebaseLanguageRepository
{
    public static function createOrUpdate(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        if (isset($language->firebase_id)) {
            static::update($language);
        } else {
            $snapshot = $firestore->collection(Firebase::languages_collection)
                ->where('code', '=', $language->code)
                ->limit(1)
                ->documents();

            if ($snapshot->isEmpty()) {
                static::create($language);
            } else {
                $firebaseLanguage = $snapshot->rows()[0]->data();
                $language->firebase_id = $snapshot->rows()[0]->id();
                $language->save();

                static::update($language);
            }
        }
    }

    private static function create(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::languages_collection)
            ->add([
                'code' => $language->code,
                'name' => $language->native,
            ]);

        $language->firebase_id = $reference->id();
        $language->save();
    }

    public static function update(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::languages_collection)->document($language->firebase_id);
        $reference->set([
            'code' => $language->code,
            'name' => $language->native
        ], ['merge' => true]);
    }

    /**
     * @param Language $language
     */
    public static function updateIconProperty(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();
        $firestore->collection(Firebase::languages_collection)->document($language->firebase_id)
            ->set([
                'icon' => $language->icon
            ], ['merge' => true]);
    }

    public static function syncIconProperty(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();
        $firebaseLanguage = $firestore->collection(Firebase::languages_collection)->document($language->firebase_id);

        if (isset($language->icon))
            $firebaseLanguage->set([
                'icon' => $language->icon
            ], ['merge' => true]);
        else {
            $data = $firebaseLanguage->snapshot()->data();
            if (isset($data['icon'])) {
                $language->icon = $data['icon'];
                $language->save();
            }
        }

    }

    /**
     * @param Language $language
     * @return bool
     * @throws Exception
     */
    public static function updateCourseProperty(Language $language)
    {
        FirebaseLanguageRepository::validateFirebaseID($language);

        $firestore = Firebase::getInstance()->firestoreClient();
        $changed = false;

        $firestoreLanguage = $firestore->collection(Firebase::languages_collection)
            ->document($language->firebase_id);
        $data = $firestoreLanguage->snapshot()->data();

        $courses = $firestore->collection(Firebase::courses_collection)
            ->where('language', '=', $language->firebase_id)
            ->documents();

        if (isset($data['course']) && $data['course'] != $courses->size() > 0)
            $changed = true;

        if ($changed)
            $firestoreLanguage->set([
                'course' => $courses->size() > 0
            ], ['merge' => true]);

        return $changed;
    }

    /**
     * @param Language $language
     * @return bool
     * @throws Exception
     */
    public static function updateTranslationsProperty(Language $language)
    {
        FirebaseLanguageRepository::validateFirebaseID($language);

        $firestore = Firebase::getInstance()->firestoreClient();
        $changed = false;

        $firestoreLanguage = $firestore->collection(Firebase::languages_collection)
            ->document($language->firebase_id);
        $data = $firestoreLanguage->snapshot()->data();

        $oldTranslations = isset($data['translations']) ? $data['translations'] : [];
        $newTranslations = [];

        $firestoreCourses = $firestore->collection(Firebase::courses_collection)
            ->where('language', '=', $language->firebase_id)
            ->documents()->rows();

        foreach ($firestoreCourses as $firestoreCourse)
            if (!in_array($firestoreCourse->get('translation'), $newTranslations)) {
                $newTranslations[] = $firestoreCourse->get('translation');
            }

        sort($oldTranslations);
        sort($newTranslations);

        if ($oldTranslations != $newTranslations) {
            $changed = true;
        }

        if ($changed)
            $firestoreLanguage->set([
                'translations' => $newTranslations
            ], ['merge' => true]);

        return $changed;
    }

    /**
     * @param Language $language
     * @throws Exception
     */
    public static function validateFirebaseID(Language $language)
    {
        if (empty($language->firebase_id))
            throw new Exception($language . '. Firebase ID is not set.');
    }

    /**
     * @param Language $language
     * @throws Exception
     */
    public static function validateIcon(Language $language)
    {
        if (empty($language->icon))
            throw new Exception($language . ". Doesn't have an icon.");
    }

    /**
     * @param Language $language
     * @throws Exception
     */
    public static function validatePlayerSettings(Language $language)
    {
        if ($language->playerSettings()->doesntExist())
            throw new Exception($language . ". Doesn't have player settings.");
    }

    /**
     * @throws RemoteConfigException
     */
    public static function incrementLanguagesVersion()
    {
        Firebase::incrementConfigParameter(Firebase::server_languages_version);
    }
}
