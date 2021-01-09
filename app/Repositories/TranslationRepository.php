<?php


namespace App\Repositories;


use App\ExerciseData;
use App\Language;
use App\Library\Audio;
use App\Library\StrUtils;
use App\Library\TextToSpeech;
use App\Translation;
use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TranslationRepository
{
    private Translation $model;

    public function __construct(Translation $translation)
    {
        $this->model = $translation;
    }

    /**
     * @param Language $language
     * @param ExerciseData $exerciseData
     * @return Translation
     */
    public static function create(Language $language, ExerciseData $exerciseData)
    {
        $translation = new Translation();
        $translation->language()->associate($language);
        $translation->exerciseData()->associate($exerciseData);
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
        if ($request->has('audio')) {
            $audio = $request->file('audio')->store('');
            $this->model->update(['content->audio' => $audio]);
            $this->model->update(['content->duration' => (int) $request->get('duration')]);
//            $this->updateAudioDuration();
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
        $speechSettings = SpeechSettingsRepository::find($this->model->exerciseData->exercise->lesson->content,
            $this->model->language);

        if ($speechSettings == null)
            throw new Exception('Speech Settings are not set.');

        $audioContent = TextToSpeech::synthesizeSpeech(
            $speechSettings, StrUtils::toPlainText($this->model->content['value']));

        // It is important file names do not contain dashes.
        $path = \Illuminate\Support\Str::random(42) . '.wav';
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

    public function toArray()
    {
        $content['language'] = $this->model->language->code;
        $content['content'] = $this->model->content;

        return $content;
    }

    /**
     * @return Translation
     */
    public function model()
    {
        return $this->model;
    }
}
