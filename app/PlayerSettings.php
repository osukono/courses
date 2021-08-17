<?php

namespace App;

use App\Repositories\PlayerSettingsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\PlayerSettings
 *
 * @property int $id
 * @property int $language_id
 * @property float $pause_after_exercise
 * @property float $listening_rate
 * @property float $practice_rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings whereListeningRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings wherePauseAfterExercise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings wherePracticeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayerSettings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlayerSettings extends Model
{
    protected $casts = [
        'pause_after_exercise' => 'float',
        'listening_rate' => 'float',
        'practice_rate' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    private PlayerSettingsRepository $repository;

    /**
     * @return PlayerSettingsRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new PlayerSettingsRepository($this);
    }
}
