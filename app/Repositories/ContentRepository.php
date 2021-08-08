<?php


namespace App\Repositories;


use App\Content;
use App\Language;
use App\Library\StrUtils;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentRepository
{
    protected Content $model;

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
        $content->topic()->associate($attributes['topic_id']);
        $content->title = $attributes['title'];
        $content->player_version = 1;
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
        $this->model->title = $attributes['title'];
        $this->model->player_version = $attributes['player_version'];
        $this->model->review_exercises = $attributes['review_exercises'];
        $this->model->capitalized_words = $attributes['capitalized_words'];
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
     * @param bool $withTarget
     * @return string
     */
    public function toPlainText(Language $language = null, bool $withTarget = true)
    {
        $content = $this->toArray();

        $data = "";

        foreach ($content['lessons'] as $lessonIndex => $lesson) {
            $data .= str_pad(($lessonIndex + 1), 2, '0', STR_PAD_LEFT) .
                '. ' . strtoupper($lesson['title']) . PHP_EOL . PHP_EOL;

            foreach ($lesson['exercises'] as $exerciseIndex => $exercise) {
                if (!isset($exercise['data']))
                    continue;

                foreach ($exercise['data'] as $dataIndex => $field) {
                    if ($withTarget && isset($field['content']['value'])) {
                        $data .= StrUtils::toPlainText($field['content']['value']) . PHP_EOL;
                        if (isset($field['content']['chunks'])) {
                            $data .= $field['content']['chunks'] . PHP_EOL;
                        }
                    }

                    if ($language != null && isset($field['translations'])) {
                        foreach ($field['translations'] as $translation)
                            if ($translation['language'] == $language->code) {
                                if (isset($translation['content']['value']))
                                    $data .= StrUtils::toPlainText($translation['content']['value']) . PHP_EOL;

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
    public function toArray()
    {
        $this->model->loadMissing([
            'lessons' => function (HasMany $query) {
                $query->orderBy('index');
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
                $query->orderBy('language_id');
            },
            'lessons.exercises.exerciseData.translations.language'
        ]);

        $content['title'] = $this->model->title ?? (string)$this->model;
        $content['language'] = $this->model->language->code;
        $content['level'] = $this->model->level->scale;
        $content['topic'] = $this->model->topic->identifier;
        $content['player_version'] = $this->model->player_version;
        $content['review_exercises'] = $this->model->review_exercises;

        foreach ($this->model->lessons as $lesson)
            $content['lessons'][] = $lesson->repository()->toArray();

        return $content;
    }

    /**
     * @return Content
     */
    public function model()
    {
        return $this->model;
    }
}
