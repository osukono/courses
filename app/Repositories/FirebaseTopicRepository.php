<?php


namespace App\Repositories;


use App\Library\Firebase;
use App\Topic;
use Exception;
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
    }

    private static function update(Topic $topic)
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::topics_collection)->document($topic->firebase_id);
        $reference->set([
            'type' => $topic->identifier
        ], ['merge' => true]);
    }

    /**
     * @param Topic $topic
     * @throws Exception
     */
    public static function validateFirebaseID(Topic $topic)
    {
        if (empty($topic->firebase_id))
            throw new Exception($topic . '. Firebase ID is not set.');
    }

    /**
     * @throws RemoteConfigException
     */
    public static function incrementTopicsVersion()
    {
        Firebase::incrementConfigParameter(Firebase::server_topics_version);
    }
}
