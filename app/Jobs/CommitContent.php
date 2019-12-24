<?php

namespace App\Jobs;

use App\Content;
use App\CourseContent;
use App\CourseLesson;
use App\Exercise;
use App\ExerciseField;
use App\Language;
use App\Lesson;
use App\Repositories\CourseContentRepository;
use App\Repositories\CourseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;

class CommitContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /** @var Content $content */
    private $content;
    /** @var Language $translation */
    private $translation;

    /**
     * Create a new job instance.
     *
     * @param Content $content
     * @param Language $translation
     */
    public function __construct(Content $content, Language $translation)
    {
        $this->prepareStatus();
        $this->content = $content;
        $this->translation = $translation;
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
            'lessons.exercises' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.exerciseFields' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.exerciseFields.field',
            'lessons.exercises.exerciseFields.translations' => function (HasMany $query) {
                $query->where('language_id', $this->translation->id);
            }

        ]);

        $this->setProgressMax($this->content->lessons->count() * 2);

        if (!$this->validateContent())
            return;

        $course = CourseRepository::findOrCreate($this->content->language, $this->translation, $this->content->level);
        $courseContent = CourseContentRepository::create($course);

        $this->commit($courseContent);

        $courseContent->repository()->enable();
    }

    private function validateContent()
    {
        $valid = true;
        $messages = [];

        if ($this->content->lessons->count() == 0) {
            $messages[] = "The content doesn't have lessons.";
            $valid = false;
        }

        foreach ($this->content->lessons as $lesson) {
            if ($lesson->title == null) {
                $messages[] = "Lesson " . $lesson->index . " doesn't have title.";
                $valid = false;
            }

            if ($lesson->exercises->count() == 0) {
                $messages[] = "Lesson " . $lesson->index . " doesn't have exercises.";
                $valid = false;
            }

            foreach ($lesson->exercises as $exercise) {
                if ($exercise->exerciseFields->count() == 0) {
                    $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " doesn't have fields";
                    $valid = false;
                }

                foreach ($exercise->exerciseFields as $exerciseField) {
                    if (!isset($exerciseField->content['value'])) {
                        $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " › Field " . $exerciseField->index . " doesn't have value.";
                        $valid = false;
                    }

                    if ($exerciseField->field->audible && !isset($exerciseField->content['audio'])) {
                        $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " › Field " . $exerciseField->index . " doesn't have audio.";
                        $valid = false;
                    }

                    if ($exerciseField->field->translatable) {
                        $translation = $exerciseField->translations->where('language_id', $this->translation->id)->first();

                        if ($translation == null) {
                            $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " › Field " . $exerciseField->index . " doesn't have translation.";
                            $valid = false;
                        }

                        if (!isset($translation->content['value'])) {
                            $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " › Field " . $exerciseField->index . " › Translation doesn't have value.";
                            $valid = false;
                        }

                        if ($exerciseField->field->audible && !isset($translation->content['audio'])) {
                            $messages[] = "Lesson " . $lesson->index . " › Exercise " . $exercise->index . " › Field " . $exerciseField->index . " › Translation doesn't have audio.";
                            $valid = false;
                        }
                    }
                }

                $this->incrementProgress();
            }
        }

        if (!$valid)
            $this->setOutput($messages);

        return $valid;
    }

    private function commit(CourseContent $courseContent)
    {
        foreach ($this->content->lessons as $lesson) {
            $courseLesson = new CourseLesson();
            $courseLesson->courseContent()->associate($courseContent);
            $courseLesson->title = $lesson->title;
            $courseLesson->uuid = $lesson->uuid;

            $content = $this->buildLessonContent($lesson);

            $courseLesson->checksum = hash("md5", json_encode($content));
            $courseLesson->exercises_count = $lesson->exercises_count;
            $courseLesson->content = $content;
            $courseLesson->save();

            $this->incrementProgress();
        }
    }

    private function buildLessonContent(Lesson $lesson)
    {
        $data = [];

        foreach ($lesson->exercises as $exercise) {
            $data['exercises'][] = $this->buildExerciseContent($exercise);
        }

        return $data;
    }

    private function buildExerciseContent(Exercise $exercise) {
        $data = [];

        foreach ($exercise->exerciseFields as $exerciseField) {
            $data['fields'][] = $this->buildExerciseFieldContent($exerciseField);
        }

        return $data;
    }

    private function buildExerciseFieldContent(ExerciseField $exerciseField) {
        $data['identifier'] = $exerciseField->field->identifier;
        $data['value'] = $exerciseField->content['value'];

        if ($exerciseField->field->audible)
            $data['audio'] = $exerciseField->content['audio'];

        if ($exerciseField->field->translatable) {
            $translation = $exerciseField->translations->where('language_id', $this->translation->id)->first();

            $data['translation']['value'] = $translation->content['value'];

            if ($exerciseField->field->audible)
                $data['translation']['audio'] = $translation->content['audio'];
        }

        return $data;
    }
}
