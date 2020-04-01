<?php

namespace App\Jobs;

use App\AppLocale;
use App\Library\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;

class LoadLocales implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->prepareStatus();
    }

    public function getDisplayName()
    {
        return "Loading locales from Firebase.";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $firebase = Firebase::getInstance()->firestoreClient();

        $documents = $firebase->collection(Firebase::localizations_collection)->documents()->rows();

        $this->setProgressMax(count($documents));

        foreach ($documents as $document) {
//            $data = $document->data();
//            if (!isset($data['key']) or !isset($data['translations']))
//                continue;

            $appLocale = AppLocale::where('key', $document->get('key'))->first();

            if ($appLocale == null) {
                $appLocale = new AppLocale();
                $appLocale->key = $document->get('key');
            }

            $values = $appLocale->values;

            foreach ($document->get('translations') as $key => $value) {
                $values[$key] = $value;
            }

            $appLocale->values = $values;
            $appLocale->save();

            $this->incrementProgress();
        }
    }
}
