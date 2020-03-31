<?php


namespace App\Repositories;


use App\Content;
use App\Language;
use App\SpeechSettings;
use Illuminate\Database\Eloquent\Builder;

class SpeechSettingsRepository
{
    private SpeechSettings $model;

    public function __construct(SpeechSettings $speechSettings)
    {
        $this->model = $speechSettings;
    }

    /**
     * @param Content $content
     * @param Language $language
     * @return Builder|SpeechSettings|null
     */
    public static function find(Content $content, Language $language)
    {
        return SpeechSettings::where('content_id', $content->id)
            ->where('language_id', $language->id)->first();
    }

    public static function createOrUpdate(Content $content, Language $language, array $attributes)
    {
        $speechSettings = SpeechSettingsRepository::find($content, $language);

        if ($speechSettings == null) {
            $speechSettings = new SpeechSettings();
            $speechSettings->content()->associate($content);
            $speechSettings->language()->associate($language);
        }

        $speechSettings->voice_name = $attributes['voice_name'];
        $speechSettings->sample_rate = $attributes['sample_rate'];
        $speechSettings->speaking_rate = $attributes['speaking_rate'];
        $speechSettings->pitch = $attributes['pitch'];
        $speechSettings->volume_gain_db = $attributes['volume_gain_db'];
        $speechSettings->save();
    }

    public function model()
    {
        return $this->model;
    }
}
