<?php

namespace App\Jobs;

use App\Content;
use App\Exercise;
use App\ExerciseData;
use App\Lesson;
use App\Repositories\LanguageRepository;
use App\Translation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
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

    public function getDisplayName()
    {
        return "Importing content.";
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $data = json_decode(Storage::get($this->json), true);

        $this->content->title = $data['title'];
        $this->content->description = $data['description'];
        $this->content->player_version = $data['player_version'];
        $this->content->review_exercises = $data['review_exercises'];
        $this->content->save();

        if (!isset($data['lessons']))
            return;

        $languages = LanguageRepository::all()->get();

        $this->setProgressMax(count($data['lessons']));

        foreach ($data['lessons'] as $jsonLesson) {
            $lesson = new Lesson();
            $lesson->content()->associate($this->content);
            $lesson->title = $jsonLesson['title'];
            $lesson->save();

            if (!isset($jsonLesson['exercises']))
                continue;

            foreach ($jsonLesson['exercises'] as $jsonExercise) {
                $exercise = new Exercise();
                $exercise->lesson()->associate($lesson);
                $exercise->save();

                if (!isset($jsonExercise['data']))
                    continue;

                foreach ($jsonExercise['data'] as $jsonExerciseData) {
                    $exerciseData = new ExerciseData();
                    $exerciseData->exercise()->associate($exercise);
                    $exerciseData->translatable = $jsonExerciseData['translatable'];
                    $exerciseData->content = $jsonExerciseData['content'];
                    $exerciseData->save();

                    if (!isset($jsonExerciseData['translations']))
                        continue;

                    foreach ($jsonExerciseData['translations'] as $jsonTranslation) {
                        $translation = new Translation();
                        $translation->exerciseData()->associate($exerciseData);
                        $translation->language()->associate($languages->where('code', $jsonTranslation['language'])->first());
                        $translation->content = $jsonTranslation['content'];
                        $translation->save();

                        unset($translation);
                    }

                    unset($exerciseData);
                }

                unset($exercise);
            }

            unset($lesson);

            $this->incrementProgress();
        }
    }
}
