<?php

namespace App\Jobs;

use App\Content;
use App\Language;
use App\Translation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;

class TextToSpeech implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    private Content $content;
    private Language $language;

    /**
     * @var int
     */
    public $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Content $content, Language $language)
    {
        $this->prepareStatus();
        $this->content = $content;
        $this->language = $language;
    }

    public function getDisplayName()
    {
        return "Generating Audio...";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->content->loadMissing([
            'language',
            'level',
            'lessons' => function (HasMany $query) {
                $query->orderBy('index');
                $query->withCount('exercises');
            },
            'lessons.disabled',
            'lessons.exercises' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.disabled',
            'lessons.exercises.exerciseData' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.exerciseData.translations' => function (HasMany $query) {
                $query->where('language_id', $this->language->id);
            },
        ]);

        $this->setProgressMax($this->content->lessons->count());

        foreach ($this->content->lessons as $lesson) {
            foreach ($lesson->exercises as $exercise) {
                foreach ($exercise->exerciseData as $exerciseData) {
                    if ($this->language->id == $this->content->language->id) {
                        if (isset($exerciseData->content['value'])) {
                            try {
                                $exerciseData->repository()->synthesizeAudio();
                            } catch (\Exception $e) {
                            }
                        }
                    } else {
                        /** @var Translation $translation */
                        $translation = $exerciseData->translations->where('language_id', $this->language->id)->first();

                        if ($translation != null and isset($translation->content['value'])) {
                            try {
                                $translation->repository()->synthesizeAudio();
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            }

            $this->incrementProgress();
        }
    }
}
