<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Repositories\TranslationRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Translation
 *
 * @property int $id
 * @property int $exercise_data_id
 * @property int $language_id
 * @property array $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\ExerciseData $exerciseData
 * @property-read \App\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereExerciseDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $disabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereDisabled($value)
 */
class Translation extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;

    protected $casts = [
        'content' => 'array'
    ];

    protected $fillable = [
        'content->value',
        'content->audio',
        'content->duration',
        'content->linear_audio',
        'content->linear_duration',
    ];

    /**
     * @return BelongsTo|ExerciseData
     */
    public function exerciseData()
    {
        return $this->belongsTo(ExerciseData::class);
    }

    /**
     * @return BelongsTo|Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    private TranslationRepository $repository;

    /**
     * @return TranslationRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new TranslationRepository($this);
    }
}
