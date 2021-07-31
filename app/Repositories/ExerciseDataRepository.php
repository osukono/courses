<?php


namespace App\Repositories;


use App\Exercise;
use App\ExerciseData;
use App\Language;
use App\Library\Audio;
use App\Library\StrUtils;
use App\Library\TextToSpeech;
use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciseDataRepository
{
    private ExerciseData $model;

    /**
     * ExerciseFieldRepository constructor.
     * @param ExerciseData $exerciseData
     */
    public function __construct(ExerciseData $exerciseData)
    {
        $this->model = $exerciseData;
    }

    /**
     * @param $id
     * @return ExerciseDataRepository
     */
    public static function find($id)
    {
        return ExerciseData::findOrFail($id)->repository();
    }

    /**
     * @return Builder|ExerciseData
     */
    public static function trashed()
    {
        return ExerciseData::onlyTrashed();
    }

    /**
     * @param Exercise $exercise
     * @return ExerciseData
     */
    public static function create(Exercise $exercise)
    {
        $exerciseData = new ExerciseData();
        $exerciseData->exercise()->associate($exercise);
        $exerciseData->save();

        return $exerciseData;
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

        if (empty($attributes['extra_chunks']))
            unset($content['extra_chunks']);
        else
            $content['extra_chunks'] = $attributes['extra_chunks'];

        if (empty($attributes['capitalized_words']))
            unset($content['capitalized_words']);
        else
            $content['capitalized_words'] = $attributes['capitalized_words'];

        $this->model->translatable = !isset($attributes['context']);

        $this->model->content = $content;
        $this->model->save();
    }

    /**
     * Update exercise's audio and duration.
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
            $duration = Audio::duration(Storage::url($this->model->content['audio']));
            $this->model->update(['content->duration' => $duration]);
        }
    }

    /**
     * @throws ApiException
     * @throws ValidationException
     * @throws Exception
     */
    public function synthesizeAudio()
    {
        $speechSettings  = SpeechSettingsRepository::find($this->model->exercise->lesson->content, $this->model->exercise->lesson->content->language);
        if ($speechSettings == null)
            throw new Exception('Speech Settings are not set.');

        $audioContent = TextToSpeech::synthesizeSpeech(
            $speechSettings, StrUtils::toPlainText($this->model->content['value']));

        // It is important that file names do not contain dashes.
        $path = \Illuminate\Support\Str::random(42) . '.opus';
        if (Storage::put($path, $audioContent)) {
            $this->model->update(['content->audio' => $path]);
            $this->updateAudioDuration();
        }
    }

    /**
     * Delete audio and duration from the content.
     */
    public function deleteAudio()
    {
        $content = $this->model->content;

        unset($content['audio']);
        unset($content['duration']);

        $this->model->content = $content;
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
     * @return array
     */
    public function toArray()
    {
        $this->model->loadMissing([
            'translations' => function (HasMany $query) {
                $query->orderBy('language_id');
            },
            'translations.language'
        ]);

        $content['translatable'] = $this->model->translatable;
        $content['content'] = $this->model->content;

        foreach ($this->model->translations as $translation) {
            if (count($translation->content))
                $content['translations'][] = $translation->repository()->toArray();
        }

        return $content;
    }

    /**
     * @return ExerciseData
     */
    public function model()
    {
        return $this->model;
    }
}
