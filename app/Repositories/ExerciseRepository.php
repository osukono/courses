<?php


namespace App\Repositories;


use App\Exercise;
use App\Language;
use App\Lesson;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciseRepository
{
    protected Exercise $model;

    public function __construct(Exercise $exercise)
    {
        $this->model = $exercise;
    }

    /**
     * @param $id
     * @return ExerciseRepository
     */
    public static function find($id)
    {
        return Exercise::findOrFail($id)->repository();
    }

    /**
     * @return Exercise|Builder
     */
    public static function trashed()
    {
        return Exercise::onlyTrashed();
    }

    /**
     * @param Lesson $lesson
     * @return Exercise
     */
    public static function create(Lesson $lesson)
    {
        $exercise = new Exercise();
        $exercise->lesson()->associate($lesson);
        $exercise->save();

        return $exercise;
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
            throw new Exception(__('admin.messages.restored.is_not_trashed', ['object' => $this->model]));

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
     * @return Exercise|null
     */
    public function previous()
    {
        return Exercise::where('lesson_id', $this->model->lesson_id)
            ->where('index', '<', $this->model->index)
            ->orderBy('index', 'desc')->first();
    }

    /**
     * @return Exercise|null
     */
    public function next()
    {
        return Exercise::where('lesson_id', $this->model->lesson_id)
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
            'exerciseData' => function (HasMany $query) {
                $query->orderBy('index');
            },
            'exerciseData.translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'exerciseData.translations.language'
        ]);

        $content = [];

        if ($this->model->disabled->count() > 0)
            foreach ($this->model->disabled as $language)
                $content['disabled'][] = $language->code;

        foreach ($this->model->exerciseData as $data) {
            $content['data'][] = $data->repository()->toArray();
        }

        return $content;
    }

    /**
     * @return Exercise
     */
    public function model()
    {
        return $this->model;
    }
}
