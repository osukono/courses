<?php

namespace App\Jobs;

use App\Content;
use App\Course;
use App\CourseLesson;
use App\Exercise;
use App\ExerciseData;
use App\Language;
use App\Lesson;
use App\LessonAsset;
use App\Library\StrUtils;
use App\Repositories\CourseRepository;
use App\Repositories\LessonAssetRepository;
use App\Translation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Imtigger\LaravelJobStatus\Trackable;

class CommitContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /** @var Content $content */
    private $content;
    /** @var Language $translation */
    private $translation;
    /** @var array $messages */
    private $messages = [];

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

    public function getDisplayName()
    {
        return "Committing...";
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
                $query->where('language_id', $this->translation->id);
            },
        ]);

        $this->setProgressMax($this->content->lessons->count() * 2);

        if (!$this->validate()) {
            $this->setOutput($this->messages);
            return;
        }

        $course = CourseRepository::findOrCreate($this->content, $this->translation);

        $course->player_version = $this->content->player_version;
        $course->review_exercises = $this->content->review_exercises;

        if ($this->content->language->capitalized_words == null && $this->content->capitalized_words == null)
            $course->capitalized_words = null;
        else
            $course->capitalized_words = $this->content->language->capitalized_words . ', ' . $this->content->capitalized_words;

        $course->minor_version += 1;
        $course->committed_at = Carbon::now();
        $course->save();

        try {
            $course->courseLessons()->delete();
        } catch (\Exception $e) {
        }

        $this->commit($course);
    }

    private function validate()
    {
        $valid = true;

        if ($this->content->lessons->reject(function (Lesson $lesson) {
            return $lesson->isDisabled($this->content->language);
        })->reject(function (Lesson $lesson) {
            return $lesson->isDisabled($this->translation);
        })->isEmpty()) {
            $this->messages[] = $this->content . " doesn't have lessons.";
            $valid = false;
        }

        foreach ($this->content->lessons as $lesson) {
            if (!$lesson->isDisabled($this->content->language) &&
                !$lesson->isDisabled($this->translation) &&
                !$this->validateLesson($lesson, "Lesson " . $lesson->index))
                $valid = false;

            $this->incrementProgress();
        }

        return $valid;
    }

    public function validateLesson(Lesson $lesson, $current)
    {
        $valid = true;

        if ($lesson->title == null) {
            $this->messages[] = $current . " doesn't have title.";
            $valid = false;
        }

        if ($lesson->exercises->reject(function (Exercise $exercise) {
            return $exercise->isDisabled($this->content->language);
        })->reject(function (Exercise $exercise) {
            return $exercise->isDisabled($this->translation);
        })->isEmpty()) {
            $this->messages[] = $current . " doesn't have exercises.";
            $valid = false;
        }

        foreach ($lesson->exercises as $exercise) {
            if (!$exercise->isDisabled($this->content->language) &&
                !$exercise->isDisabled($this->translation) &&
                !$this->validateExercise($exercise, $current . " › Exercise " . $exercise->index))
                $valid = false;
        }

        return $valid;
    }

    public function validateExercise(Exercise $exercise, $current)
    {
        $valid = true;

        if ($exercise->exerciseData->count() == 0) {
            $this->messages[] = $current . " doesn't have data.";
            $valid = false;
        }

        foreach ($exercise->exerciseData as $exerciseData) {
            $_current = $current . " › Data " . $exerciseData->index;
            if (!$this->validateContent($exerciseData->content, $_current, $exerciseData->translatable))
                $valid = false;

            if ($exerciseData->translatable) {
                $translation = $exerciseData->translations->where('language_id', $this->translation->id)->first();

                if ($translation == null) {
                    $this->messages[] = $_current . " doesn't have translation.";
                    $valid = false;
                    continue;
                }

                if (!$this->validateContent($translation->content, $_current . " › Translation", false))
                    $valid = false;
            }
        }

        return $valid;
    }

    public function validateContent($content, $current, $translatable)
    {
        $valid = true;

        if (!isset($content['value'])) {
            $this->messages[] = $current . " doesn't have value.";
            $valid = false;
        }

        if ($translatable && !isset($content['chunks'])) {
            $this->messages[] = $current . " doesn't have chunks.";
            $valid = false;
        }

        if (!isset($content['audio'])) {
            $this->messages[] = $current . " doesn't have an audio.";
            $valid = false;
        }

        if (!isset($content['duration']) or $content['duration'] == 0) {
            $this->messages[] = $current . " doesn't have an audio duration.";
            $valid = false;
        }

        if (!isset($content['linear_audio'])) {
            $this->messages[] = $current . " doesn't have a linear audio.";
            $valid = false;
        }

        if (!isset($content['linear_duration']) or $content['linear_duration'] == 0) {
            $this->messages[] = $current . " doesn't have a linear audio duration.";
            $valid = false;
        }

        return $valid;
    }

    private function commit(Course $course)
    {
        foreach ($this->content->lessons as $lesson) {
            if ($lesson->isDisabled($this->content->language) ||
                $lesson->isDisabled($this->translation))
                continue;

            $courseLesson = new CourseLesson();
            $courseLesson->course()->associate($course);
            $courseLesson->title = $lesson->title;

            $lessonImage = LessonAssetRepository::getImage($lesson, $this->content->language);
            $lessonTranslationImage = LessonAssetRepository::getImage($lesson, $this->translation);

            if ($lessonTranslationImage !== null)
                $courseLesson->image = $lessonTranslationImage;
            else if ($lessonImage !== null)
                $courseLesson->image = $lessonImage;

            $lessonDescription = LessonAssetRepository::getDescription($lesson, $this->content->language);
            $lessonTranslatedDescription = LessonAssetRepository::getDescription($lesson, $this->translation);

            if ($lessonTranslatedDescription !== null)
                $courseLesson->description = $lessonTranslatedDescription;
            else if ($lessonDescription !== null)
                $courseLesson->description = $lessonDescription;

            $lessonGrammar = LessonAssetRepository::getGrammarPoint($lesson, $this->content->language);
            $lessonTranslatedGrammar = LessonAssetRepository::getGrammarPoint($lesson, $this->translation);

            if ($lessonTranslatedGrammar !== null)
                $courseLesson->grammar = $lessonTranslatedGrammar;
            else if ($lessonGrammar !== null)
                $courseLesson->grammar = $lessonGrammar;

            $content = $this->commitLesson($lesson);

            $courseLesson->exercises_count = $lesson->exercises->reject(function (Exercise $exercise) {
                return $exercise->isDisabled($this->content->language);
            })->reject(function (Exercise $exercise) {
                return $exercise->isDisabled($this->translation);
            })->count();

            $courseLesson->content = $content;
            $courseLesson->save();

            $this->incrementProgress();
        }
    }

    private function commitLesson(Lesson $lesson)
    {
        $data = [];

        foreach ($lesson->exercises as $exercise) {
            if ($exercise->isDisabled($this->content->language) ||
                $exercise->isDisabled($this->translation))
                continue;

            $data['exercises'][] = $this->commitExercise($exercise);
        }

        return $data;
    }

    private function commitExercise(Exercise $exercise)
    {
        $data['index'] = $exercise->index;

        foreach ($exercise->exerciseData as $exerciseData) {
            $data['data'][] = $this->commitExerciseData($exerciseData);
        }

        return $data;
    }

    private function commitExerciseData(ExerciseData $exerciseData)
    {
        $data['value'] = StrUtils::apostrophe($exerciseData->content['value']);
        $data['audio'] = $exerciseData->content['audio'];
        $data['duration'] = (int) $exerciseData->content['duration'];
        $data['linear_audio'] = $exerciseData->content['linear_audio'];
        $data['linear_duration'] = $exerciseData->content['linear_duration'];
        if (isset($exerciseData->content['chunks'])) {
            $data['chunks'] = StrUtils::apostrophe($exerciseData->content['chunks']);
        }
        if (isset($exerciseData->content['extra_chunks'])) {
            $data['extra_chunks'] = StrUtils::apostrophe($exerciseData->content['extra_chunks']);
        }
        if (isset($exerciseData->content['capitalized_words'])) {
            $data['capitalized_words'] = StrUtils::apostrophe($exerciseData->content['capitalized_words']);
        }

        if ($exerciseData->translatable) {
            /** @var Translation $translation */
            $translation = $exerciseData->translations->where('language_id', $this->translation->id)->first();

            $data['translation']['value'] = StrUtils::apostrophe($translation->content['value']);
            $data['translation']['audio'] = $translation->content['audio'];
            $data['translation']['duration'] = (int) $translation->content['duration'];
            $data['translation']['linear_audio'] = $translation->content['linear_audio'];
            $data['translation']['linear_duration'] = $translation->content['linear_duration'];
        }

        return $data;
    }
}
