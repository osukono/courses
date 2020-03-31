<?php

namespace App\Library;

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Kreait\Firebase\Exception\RemoteConfigException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\RemoteConfig;
use Kreait\Firebase\RemoteConfig\Parameter;
use Kreait\Firebase\ServiceAccount;

final class Firebase
{
    public const languages_collection = '_languages';
    public const topics_collection = '_topics';
    public const courses_collection = '_courses';
    public const lessons_collection = '_lessons';
    public const exercises_collection = '_exercises';

    public const server_courses_version = '_server_courses_version';
    public const server_topics_version = '_server_topics_version';
    public const server_languages_version = '_server_languages_version';
    public const server_localizations_version = '_server_localizations_version';

    private static ?Firebase $instance = null;
    private static ServiceAccount $serviceAccount;
    private static StorageClient $storageClient;
    private static FirestoreClient $firestoreClient;
    private static RemoteConfig $remoteConfig;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(): Firebase
    {
        if (static::$instance === null) {
            static::$instance = new static();
            static::$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/yummy-lingo-45fd015ad4aa.json');
        }

        return static::$instance;
    }

    /**
     * @param $name
     * @throws RemoteConfigException
     */
    public static function incrementConfigParameter($name)
    {
        $remoteConfig = Firebase::getInstance()->remoteConfig();

        $template = $remoteConfig->get();

        $parameter = Arr::first($template->parameters(), function (Parameter $value) use ($name) {
            return $value->name() === $name;
        }, Parameter::named($name, "0"));

        $value = (integer) $parameter->defaultValue()->jsonSerialize()['value'];

        $remoteConfig->publish(
            $template->withParameter(
                Parameter::named($name, (string) ($value + 1))
            )
        );
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    public function remoteConfig(): RemoteConfig
    {
        if (! isset(static::$remoteConfig)) {
            static::$remoteConfig = (new Factory())
                ->withServiceAccount(static::$serviceAccount)
                ->withDatabaseUri(new Uri(env('FIREBASE_URI')))
                ->createRemoteConfig();
        }

        return static::$remoteConfig;
    }

    public function firestoreClient(): FirestoreClient
    {
        if (! isset(static::$firestoreClient)) {
            static::$firestoreClient = (new Factory())
                ->withServiceAccount(static::$serviceAccount)
                ->withDatabaseUri(new Uri(env('FIREBASE_URI')))
                ->createFirestore()->database();
        }

        return static::$firestoreClient;
    }

    /**
     * @param UploadedFile $file
     * @param $path
     * @return string
     * @throws FileNotFoundException
     */
    public function uploadFile(UploadedFile $file, $path)
    {
        $fileName = $path . '/' . \Illuminate\Support\Str::random(42) . '.' . $file->clientExtension();
        $accessToken = (string)\Illuminate\Support\Str::uuid();

        $this->getBucket()->upload($file->get(), [
            'uploadType' => 'media',
            'name' => $fileName,
            'metadata' => [
                'metadata' => [
                    'firebaseStorageDownloadTokens' => $accessToken
                ]
            ]
        ]);
        return "https://firebasestorage.googleapis.com/v0/b/" . env('FIREBASE_STORAGE_BUCKET') . "/o/" . urlencode($fileName) . "?alt=media&token=" . $accessToken;
    }

    private function getBucket(): Bucket
    {
        static::connectToStorage();
        return self::$storageClient->bucket(env('FIREBASE_STORAGE_BUCKET'));
    }

    private function connectToStorage()
    {
        if (!isset(static::$storageClient)) {
            self::$storageClient = (new Factory())
                ->withServiceAccount(static::$serviceAccount)
                ->createStorage()->getStorageClient();
        }
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }
}
