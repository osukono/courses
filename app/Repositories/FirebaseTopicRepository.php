<?php


namespace App\Repositories;


use App\Library\Firebase;
use App\Topic;
use Kreait\Firebase\Exception\RemoteConfigException;

class FirebaseTopicRepository
{
    public static function createOrUpdate(Topic $topic)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        if (isset($topic->firebase_id)) {
            static::update($topic);
        } else {
            $snapshot = $firestore->collection(Firebase::topics_collection)
                ->where('type', '=', $topic->identifier)
                ->limit(1)
                ->documents();

            if ($snapshot->isEmpty()) {
                static::create($topic);
            } else {
                $topic->firebase_id = $snapshot->rows()[0]->id();
                $topic->save();

                static::update($topic);
            }
        }
    }

    private static function create(Topic $topic)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::topics_collection)
            ->add([
                'type' => $topic->identifier
            ]);

        $topic->firebase_id = $reference->id();
        $topic->save();

//        static::incrementTopicsVersion();
    }

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
    private static function incrementTopicsVersion()
    {
        Firebase::incrementConfigParameter('server_topics_version');
    }
}
