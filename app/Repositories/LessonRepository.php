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
    /** @var Lesson $model */
    protected $model;

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
        $lesson->uuid = Str::uuid();
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
    public function exportAsArray()
    {
        $this->model->loadMissing([
            'exercises' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'exercises.exerciseFields' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'exercises.exerciseFields.field',
            'exercises.exerciseFields.translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'exercises.exerciseFields.translations.language'
        ]);

        $data['title'] = $this->model->title;

        foreach ($this->model->exercises as $exercise)
            $data['exercises'][] = $exercise->repository()->exportAsArray();

        return $data;
    }

    /**
     * @return Lesson
     */
    public function model()
    {
        return $this->model;
    }
}
