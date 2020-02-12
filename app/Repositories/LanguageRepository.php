<?php


namespace App\Repositories;


use App\Language;
use App\TextToSpeechSettings;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class LanguageRepository
{
    /** @var Language $model */
    protected $model;

    /**
     * LanguageRepository constructor.
     * @param Language $language
     */
    public function __construct(Language $language)
    {
        $this->model = $language;
    }

    /**
     * @param $id
     * @return LanguageRepository
     */
    public static function find($id)
    {
        return Language::findOrFail($id)->repository();
    }

    /**
     * @return Builder|Language
     */
    public static function all()
    {
        return Language::query();
    }

    /**
     * @param array $attributes
     * @return Language
     */
    public static function create(array $attributes)
    {
        $language = new Language();
        $language->name = $attributes['name'];
        $language->code = $attributes['code'];
        $language->save();

        if (isset($attributes['voice_name'], $attributes['speaking_rate'], $attributes['pitch'])) {
            $textToSpeechSettings = new TextToSpeechSettings();
            $textToSpeechSettings->voice_name = $attributes['voice_name'];
            $textToSpeechSettings->speaking_rate = $attributes['speaking_rate'];
            $textToSpeechSettings->pitch = $attributes['pitch'];
            $textToSpeechSettings->language()->associate($language);
            $textToSpeechSettings->save();
        }

        return $language;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->code = $attributes['code'];
        $this->model->slug = null;
        $this->model->save();

        $this->model->textToSpeechSettings()->updateOrCreate([
            'voice_name' => $attributes['voice_name'],
            'speaking_rate' => $attributes['speaking_rate'],
            'pitch' => $attributes['pitch']
        ]);
    }

    /**
     * @throws Exception
     */
    public function destroy()
    {
        $this->model->delete();
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
     * @return Language
     */
    public function model()
    {
        return $this->model;
    }
}
