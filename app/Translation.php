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
 * @property int $disabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\ExerciseData $exerciseData
 * @property-read \App\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereExerciseDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @mixin \Eloquent
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
