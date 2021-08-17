<?php

namespace App;

use App\Repositories\SpeechSettingsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\SpeechSettings
 *
 * @property int $id
 * @property int $content_id
 * @property int $language_id
 * @property string $voice_name
 * @property string $speaking_rate
 * @property string $pitch
 * @property string $volume_gain_db
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Content $content
 * @property-read \App\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings wherePitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereSpeakingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereVoiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpeechSettings whereVolumeGainDb($value)
 * @mixin \Eloquent
 */
class SpeechSettings extends Model
{
    /**
     * @return BelongsTo|Content
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * @return BelongsTo|Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    private SpeechSettingsRepository $repository;

    /**
     * @return SpeechSettingsRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new SpeechSettingsRepository($this);
    }
}
