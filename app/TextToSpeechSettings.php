<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\TextToSpeechSettings
 *
 * @property int $id
 * @property int $language_id
 * @property string $voice_name
 * @property float $speaking_rate
 * @property float $pitch
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings wherePitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereSpeakingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextToSpeechSettings whereVoiceName($value)
 * @mixin \Eloquent
 */
class TextToSpeechSettings extends Model
{
    protected $fillable = [
        'voice_name',
        'speaking_rate',
        'pitch'
    ];

    /**
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
