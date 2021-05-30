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
        $playerSettings->listening_rate = $attributes['listening_rate'];
        $playerSettings->practice_rate = $attributes['practice_rate'];

        $playerSettings->save();

        return $playerSettings;
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->pause_after_exercise = $attributes['pause_after_exercise'];
        $this->model->listening_rate = $attributes['listening_rate'];
        $this->model->practice_rate = $attributes['practice_rate'];

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
