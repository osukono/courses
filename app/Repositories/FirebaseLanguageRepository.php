<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use Kreait\Firebase\Exception\RemoteConfigException;
use Kreait\Firebase\RemoteConfig\Parameter;

class FirebaseLanguageRepository
{
    public function createOrUpdate(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        if (isset($topic->firebase_id)) {
            static::update($language);
        } else {
            $snapshot = $firestore->collection(Firebase::languages_collection)
                ->where('code', '=', $language->code)
                ->limit(1)
                ->documents();

            if ($snapshot->isEmpty()) {
                static::create($language);
            } else {
                $language->firebase_id = $snapshot->rows()[0]->id();
                $language->save();

                static::update($language);
            }
        }
    }

    /*private static function create(Language $language)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::languages_collection)
            ->add([
                'name' => $language->native,
                'code' => $language->code
            ]);

        $topic->firebase_id = $reference->id();
        $topic->save();
    }*/

    private static function update(Topic $topic)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::topics_collection)->document($topic->firebase_id);
        $reference->set([
            'type' => $topic->identifier
        ], ['merge' => true]);

//        static::incrementTopicsVersion();
    }

    /**
     * @throws RemoteConfigException
     */
    public static function incrementLanguagesVersion()
    {
        Firebase::incrementConfigParameter('server_languages_version');
    }
}
