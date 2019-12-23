<?php

namespace App\Jobs;

use App\Content;
use App\Exercise;
use App\ExerciseField;
use App\Lesson;
use App\Repositories\FieldRepository;
use App\Repositories\LanguageRepository;
use App\Translation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imtigger\LaravelJobStatus\Trackable;

class ImportContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /** @var Content $content */
    private $content;
    /** @var string $json */
    private $json;

    /**
     * Create a new job instance.
     *
     * @param Content $content
     * @param $json
     */
    public function __construct(Content $content, $json)
    {
        $this->prepareStatus();
        $this->content = $content;
        $this->json = $json;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $data = json_decode(Storage::get($this->json), true);

        if (!isset($data['lessons']))
            return;

        $fields = FieldRepository::all()->get();
        $languages = LanguageRepository::all()->get();

        $this->setProgressMax(count($data['lessons']));

        foreach ($data['lessons'] as $jsonLesson) {
            $lesson = new Lesson();
            $lesson->content()->associate($this->content);
            $lesson->title = $jsonLesson['title'];
            $lesson->uuid = Str::uuid();
            $lesson->save();

            if (!isset($jsonLesson['exercises']))
                continue;

            foreach ($jsonLesson['exercises'] as $jsonExercise) {
                $exercise = new Exercise();
                $exercise->lesson()->associate($lesson);
                $exercise->save();

                if (!isset($jsonExercise['fields']))
                    continue;

                foreach ($jsonExercise['fields'] as $jsonExerciseField) {
                    $exerciseField = new ExerciseField();
                    $exerciseField->exercise()->associate($exercise);
                    $exerciseField->field()->associate($fields->where('identifier', $jsonExerciseField['type'])->first());
                    $exerciseField->content = $jsonExerciseField['content'];
                    $exerciseField->save();

                    if (!isset($jsonExerciseField['translations']))
                        continue;

                    foreach ($jsonExerciseField['translations'] as $jsonTranslation) {
                        $translation = new Translation();
                        $translation->exerciseField()->associate($exerciseField);
                        $translation->language()->associate($languages->where('code', $jsonTranslation['language'])->first());
                        $translation->content = $jsonTranslation['content'];
                        $translation->save();

                        unset($translation);
                    }

                    unset($exerciseField);
                }

                unset($exercise);
            }

            unset($lesson);

            $this->incrementProgress();
        }
    }
}
