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
 * @property float $pause_between
 * @property float $pause_practice_1
 * @property float $pause_practice_2
 * @property float $pause_practice_3
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings wherePauseAfterExercise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings wherePauseBetween($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings wherePausePractice1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings wherePausePractice2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings wherePausePractice3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlayerSettings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlayerSettings extends Model
{
    protected $casts = [
        'pause_after_exercise' => 'float',
        'pause_between' => 'float',
        'pause_practice_1' => 'float',
        'pause_practice_2' => 'float',
        'pause_practice_3' => 'float'
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
        return isset($this->repository) ? $this->repository : $this->repository = new PlayerSettingsRepository($this);
    }
}
