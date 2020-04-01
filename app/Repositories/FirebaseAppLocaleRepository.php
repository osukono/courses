<?php


namespace App\Repositories;


use App\AppLocale;
use App\Library\Firebase;
use Kreait\Firebase\Exception\RemoteConfigException;

class FirebaseAppLocaleRepository
{
    public static function createOrUpdate(AppLocale $appLocale)
    {
        $firebase = Firebase::getInstance()->firestoreClient();

        if ($firebase->collection(Firebase::localizations_collection)
            ->where('key', '=', $appLocale->key)->documents()->isEmpty()) {
            $firebase->collection(Firebase::localizations_collection)
                ->add([
                    'key' => $appLocale->key,
                    'translations' => $appLocale->values
                ]);
        } else {
            $firebase->collection(Firebase::localizations_collection)
                ->where('key', '=', $appLocale->key)
                ->limit(1)->documents()->rows()[0]
                ->reference()->set([
                    'translations' => $appLocale->values
                ], ['merge' => true]);
        }
    }

    /**
     * @throws RemoteConfigException
     */
    public static function incrementLocalizationsVersion()
    {
        Firebase::incrementConfigParameter(Firebase::server_localizations_version);
    }
}
