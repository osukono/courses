<?php


namespace App\Repositories;


use App\Exercise;
use App\ExerciseField;
use App\Field;
use App\Library\Str;
use App\Library\TextToSpeech;
use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciseFieldRepository
{
    /** @var ExerciseField */
    private $model;

    /**
     * ExerciseFieldRepository constructor.
     * @param ExerciseField $exerciseField
     */
    public function __construct(ExerciseField $exerciseField)
    {
        $this->model = $exerciseField;
    }

    /**
     * @param $id
     * @return ExerciseFieldRepository
     */
    public static function find($id)
    {
        return ExerciseField::findOrFail($id)->repository();
    }

    /**
     * @return Builder|ExerciseField
     */
    public static function trashed()
    {
        return ExerciseField::onlyTrashed();
    }

    /**
     * @param Exercise $exercise
     * @param array $attributes
     * @return ExerciseField
     */
    public static function create(Exercise $exercise, array $attributes)
    {
        $exerciseField = new ExerciseField();
        $exerciseField->exercise()->associate($exercise);
        $exerciseField->field()->associate($attributes['field_id']);
        $exerciseField->save();

        return $exerciseField;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->update(['content->value' => $attributes['value']]);
//        if ($this->model->field->audible && isset($attributes['audio'])) {
//            $audio = $attributes['audio']->store('audio');
//            $this->model->update(['content->audio' => $audio]);
//        }
    }

    public function updateAudio(Request $request)
    {
        if ($this->model->field->audible && $request->has('audio')) {
            $audio = $request->file('audio')->store('audio');
            $this->model->update(['content->audio' => $audio]);
        }
    }

    /**
     * @throws ApiException
     * @throws ValidationException
     */
    public function synthesizeAudio()
    {
        $audioContent = TextToSpeech::synthesizeSpeech(
            $this->model->exercise->lesson->content->language, Str::toPlainText($this->model->content['value']));
        $path = 'audio/' . (string) \Illuminate\Support\Str::uuid() . '.wav';
        if (Storage::put($path, $audioContent)) {
            $this->model->update(['content->audio' => $path]);
        }
    }

    public function deleteAudio()
    {
        $this->model->update(['content->audio' => null]);
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
        if (! $this->model->trashed())
            throw new Exception(__('admin.messages.restored.is_not_trashed', ['object' => $this->model]));

        $this->model->restore();
        $this->model->refreshSequence();
    }

    /**
     * @return array
     */
    public function exportAsArray()
    {
        $this->model->loadMissing([
            'field',
            'translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'translations.language'
        ]);

        $data['type'] = $this->model->field->identifier;
        $data['content'] = $this->model->content;

        if ($this->model->field->translatable) {
            foreach ($this->model->translations as $translation) {
                $data['translations'][] = $translation->repository()->exportAsArray();
            }
        }

        return $data;
    }

    /**
     * @return ExerciseField
     */
    public function model()
    {
        return $this->model;
    }
}
