<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use App\PlayerSettings;
use Illuminate\Support\Arr;

class PlayerSettingsRepository
{
    private PlayerSettings $model;

    public function __construct(PlayerSettings $playerSettings)
    {
        $this->model = $playerSettings;
    }

    /**
     * @param array $attributes
     * @param Language $language
     * @return PlayerSettings
     */
    public static function create(array $attributes, Language $language)
    {
        $playerSettings = new PlayerSettings();

        $playerSettings->language()->associate($language);
        $playerSettings->pause_after_exercise = $attributes['pause_after_exercise'];
        $playerSettings->pause_between = $attributes['pause_between'];
        $playerSettings->pause_practice_1 = $attributes['pause_practice_1'];
        $playerSettings->pause_practice_2 = $attributes['pause_practice_2'];
        $playerSettings->pause_practice_3 = $attributes['pause_practice_3'];

        $playerSettings->save();

        return $playerSettings;
    }

    public static function syncWithFirebase(Language $language)
    {
        $playerSettings = $language->playerSettings;

        if ($playerSettings == null) {
            $playerSettings = new PlayerSettings();
            $playerSettings->language()->associate($language);
        }

        $firebase = Firebase::getInstance()->firestoreClient();

        $languageSnapshot = $firebase->collection(Firebase::languages_collection)
            ->document($language->firebase_id)->snapshot();

        if (Arr::has($languageSnapshot->data(), [
            'pause_after_exercise',
            'pause_between',
            'pause_practise_1',
            'pause_practise_2',
            'pause_practise_3'
        ])) {
            $playerSettings->pause_after_exercise = $languageSnapshot->get('pause_after_exercise');
            $playerSettings->pause_between = $languageSnapshot->get('pause_between');
            $playerSettings->pause_practice_1 = $languageSnapshot->get('pause_practise_1');
            $playerSettings->pause_practice_2 = $languageSnapshot->get('pause_practise_2');
            $playerSettings->pause_practice_3 = $languageSnapshot->get('pause_practise_3');
            $playerSettings->save();
        }
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->pause_after_exercise = $attributes['pause_after_exercise'];
        $this->model->pause_between = $attributes['pause_between'];
        $this->model->pause_practice_1 = $attributes['pause_practice_1'];
        $this->model->pause_practice_2 = $attributes['pause_practice_2'];
        $this->model->pause_practice_3 = $attributes['pause_practice_3'];

        $this->model->save();
    }

    public function updateFireBaseDocument()
    {
        $firebase = Firebase::getInstance()->firestoreClient();

        $languageReference = $firebase->collection(Firebase::languages_collection)
            ->document($this->model->language->firebase_id);

        $languageReference->set([
            'pause_after_exercise' => $this->model->pause_after_exercise,
            'pause_between' => $this->model->pause_between,
            'pause_practise_1' => $this->model->pause_practice_1,
            'pause_practise_2' => $this->model->pause_practice_2,
            'pause_practise_3' => $this->model->pause_practice_3
        ], ['merge' => true]);
    }

    /**
     * @return PlayerSettings
     */
    public function model()
    {
        return $this->model;
    }
}
