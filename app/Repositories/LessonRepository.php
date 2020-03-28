<?php


namespace App\Repositories;


use App\Content;
use App\Exercise;
use App\Language;
use App\Lesson;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class LessonRepository
{
    protected Lesson $model;

    /**
     * LessonRepository constructor.
     * @param Lesson $lesson
     */
    public function __construct(Lesson $lesson)
    {
        $this->model = $lesson;
    }

    /**
     * @param $id
     * @return LessonRepository
     */
    public static function find($id)
    {
        return Lesson::findOrFail($id)->repository();
    }

    /**
     * @return Builder|Lesson
     */
    public static function trashed()
    {
        return Lesson::onlyTrashed();
    }

    /**
     * @param Content $content
     * @param array $attributes
     * @return Lesson
     */
    public static function create(Content $content, array $attributes)
    {
        $lesson = new Lesson();
        $lesson->content()->associate($content);
        $lesson->title = $attributes['title'];
        $lesson->save();

        return $lesson;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->title = $attributes['title'];
        $this->model->save();
    }

    public function move($index)
    {
        $this->model->move($index);
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
            throw new Exception(__('admin.messages.restored.is_not_trashed'), ['object' => $this->model]);

        $this->model->restore();
        $this->model->refreshSequence();
    }

    /**
     * @param Language $language
     */
    public function disable(Language $language)
    {
        $this->model->disabled()->syncWithoutDetaching($language);
    }

    /**
     * @param Language $language
     */
    public function enable(Language $language)
    {
        $this->model->disabled()->detach($language);
    }

    /**
     * @return Lesson|null
     */
    public function previous()
    {
        return Lesson::where('content_id', $this->model->content_id)
            ->where('index', '<', $this->model->index)
            ->orderBy('index', 'desc')->first();
    }

    /**
     * @return Lesson|null
     */
    public function next()
    {
        return Lesson::where('content_id', $this->model->content_id)
            ->where('index', '>', $this->model->index)
            ->orderBy('index', 'asc')->first();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $this->model->loadMissing([
            'disabled',
            'exercises' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'exercises.disabled',
            'exercises.exerciseData' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'exercises.exerciseData.translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'exercises.exerciseData.translations.language'
        ]);

        $content['title'] = $this->model->title;

        if ($this->model->disabled->count())
            foreach ($this->model->disabled as $language)
                $content['disabled'][] = $language->code;

        foreach ($this->model->exercises as $exercise)
            $content['exercises'][] = $exercise->repository()->toArray();

        return $content;
    }

    /**
     * @return Lesson
     */
    public function model()
    {
        return $this->model;
    }
}
