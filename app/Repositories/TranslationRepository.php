<?php


namespace App\Repositories;


use App\ExerciseField;
use App\Language;
use App\Library\Str;
use App\Library\TextToSpeech;
use App\Translation;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Support\Facades\Storage;

class TranslationRepository
{
    /** @var Translation $translation */
    private $model;

    public function __construct(Translation $translation)
    {
        $this->model = $translation;
    }

    /**
     * @param Language $language
     * @param ExerciseField $exerciseField
     * @return Translation
     */
    public static function create(Language $language, ExerciseField $exerciseField)
    {
        $translation = new Translation();
        $translation->language()->associate($language);
        $translation->exerciseField()->associate($exerciseField);
        $translation->save();

        return $translation;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->update(['content->value' => $attributes['value']]);
        if ($this->model->exerciseField->field->audible && isset($attributes['audio'])) {
            $audio = $attributes['audio']->store('');
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
            $this->model->language, Str::toPlainText($this->model->content['value']));
        $path = (string) \Illuminate\Support\Str::uuid() . '.wav';
        if (Storage::put($path, $audioContent)) {
            $this->model->update(['content->audio' => $path]);
        }
    }

    public function deleteAudio()
    {
        $this->model->update(['content->audio' => null]);
    }

    public function exportAsArray()
    {
        $this->model->loadMissing([
            'language'
        ]);

        $data['language'] = $this->model->language->code;
        $data['content'] = $this->model->content;

        return $data;
    }

    /**
     * @return Translation
     */
    public function model()
    {
        return $this->model;
    }
}
