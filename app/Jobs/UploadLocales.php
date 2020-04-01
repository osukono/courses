<?php

namespace App\Jobs;

use App\Repositories\AppLocaleRepository;
use App\Repositories\FirebaseAppLocaleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Kreait\Firebase\Exception\RemoteConfigException;

class UploadLocales implements ShouldQueue
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
        return "Uploading locales to  Firebase.";
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RemoteConfigException
     */
    public function handle()
    {
        $this->setProgressMax(AppLocaleRepository::all()->count());

        $appLocales = AppLocaleRepository::all()->get();

        foreach ($appLocales as $appLocale) {
            FirebaseAppLocaleRepository::createOrUpdate($appLocale);
            $this->incrementProgress();
        }

        FirebaseAppLocaleRepository::incrementLocalizationsVersion();
    }
}
