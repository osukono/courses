<?php


namespace App\Repositories;


use App\Language;
use App\PlayerSettings;

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

    /**
     * @return PlayerSettings
     */
    public function model()
    {
        return $this->model;
    }
}
