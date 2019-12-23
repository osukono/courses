<?php


namespace App\Repositories;


use App\Content;
use App\Exercise;
use App\ExerciseField;
use App\Language;
use App\Lesson;
use App\Library\Str;
use App\Translation;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentRepository
{
    /** @var Content $model */
    protected $model;

    public function __construct(Content $content)
    {
        $this->model = $content;
    }

    /**
     * @param int $id
     * @return Content
     */
    public static function find($id)
    {
        return Content::findOrFail($id);
    }

    /**
     * @return Builder|Content
     */
    public static function all()
    {
        return Content::query();
    }

    /**
     * @return Builder|Content
     */
    public static function trashed()
    {
        return Content::onlyTrashed();
    }

    /**
     * @param array $attributes
     * @return Content
     */
    public static function create(array $attributes)
    {
        $content = new Content();
        $content->language()->associate($attributes['language_id']);
        $content->level()->associate($attributes['level_id']);
        $content->save();

        return $content;
    }

    /**
     * @throws Exception
     */
    public function delete()
    {
        if ($this->model->trashed())
            throw new Exception(__('admin.messages.trashed.already_trashed', ['object' => $this->model]));

        $this->model->delete();
    }

    /**
     * @throws Exception
     */
    public function restore()
    {
        if (!$this->model->trashed())
            throw new Exception(__('admin.messages.restored.is_not_trashed', ['object' => $this->model]));

        $this->model->restore();
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->description = $attributes['description'];
        $this->model->save();
    }

    /**
     * @param User $user
     */
    public function assignEditor(User $user)
    {
        $this->model->editors()->syncWithoutDetaching($user);
    }

    /**
     * @param User $user
     */
    public function removeEditor(User $user)
    {
        $this->model->editors()->detach($user);
    }

    /**
     * @param Language|null $language
     * @return string
     */
    public function exportAsText(Language $language = null)
    {
        $content = $this->exportAsArray();

        $data = "";

        foreach ($content['lessons'] as $lessonKey => $lesson) {
            $data .= $lesson['title'] . PHP_EOL . PHP_EOL;

            foreach ($lesson['exercises'] as $exerciseKey => $exercise) {
                if (!isset($exercise['fields']))
                    continue;

                foreach ($exercise['fields'] as $fieldKey => $field) {
//                    if (isset($field['content']['value']))
//                        $data .= Str::toPlainText($field['content']['value']) . PHP_EOL;

                    if ($language != null && isset($field['translations'])) {
                        foreach ($field['translations'] as $translation)
                            if ($translation['language'] == $language->code) {
                                if (isset($translation['content']['value']))
                                    $data .= Str::toPlainText($translation['content']['value']) . PHP_EOL;

                                break;
                            }
                    }
                }
                $data .= PHP_EOL;
            }
            $data .= PHP_EOL;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function exportAsArray()
    {
        $this->model->loadMissing([
            'lessons' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.exerciseFields' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'lessons.exercises.exerciseFields.field',
            'lessons.exercises.exerciseFields.translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'lessons.exercises.exerciseFields.translations.language'
        ]);

        $data['title'] = (string)$this->model;
        $data['language'] = $this->model->language->code;
        $data['level'] = $this->model->level->name;

        foreach ($this->model->lessons as $lesson)
            $data['lessons'][] = $lesson->repository()->exportAsArray();

        return $data;
    }

    /**
     * @return Content
     */
    public function model()
    {
        return $this->model;
    }
}
