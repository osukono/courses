<?php


namespace App\Repositories;


use App\ExerciseField;
use App\Language;
use App\Library\Audio;
use App\Library\Str;
use App\Library\TextToSpeech;
use App\Translation;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Http\Request;
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
        $content = $this->model->content;

        if (empty($attributes['value']))
            unset($content['value']);
        else
            $content['value'] = $attributes['value'];

        $this->model->content = $content;
        $this->model->save();
    }

    /**
     * Update translation's audio and duration.
     * @param Request $request
     */
    public function updateAudio(Request $request)
    {
        if ($this->model->exerciseField->field->audible && $request->has('audio')) {
            $audio = $request->file('audio')->store('');
            $this->model->update(['content->audio' => $audio]);

            $this->updateAudioDuration();
        }
    }

    public function updateAudioDuration()
    {
        if (isset($this->model->content['audio'])) {
            $duration = Audio::length(Storage::url($this->model->content['audio']));
            $this->model->update(['content->duration' => $duration]);
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
            $this->updateAudioDuration();
        }
    }

    public function deleteAudio()
    {
        $content = $this->model->content;

        unset($content['audio']);
        unset($content['duration']);
        
        $this->model->content = $content;
        $this->model->save();
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
