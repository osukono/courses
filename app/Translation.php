<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Repositories\TranslationRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Translation
 *
 * @property int $id
 * @property int $exercise_field_id
 * @property int $language_id
 * @property mixed $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereExerciseFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Translation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\ExerciseField $exerciseField
 * @property-read \App\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Translation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Translation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Translation withoutTrashed()
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
        'content->duration'
    ];

    /**
     * @return BelongsTo|ExerciseField
     */
    public function exerciseField()
    {
        return $this->belongsTo(ExerciseField::class);
    }

    /**
     * @return BelongsTo|Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /** @var TranslationRepository */
    private $repository;

    /**
     * @return TranslationRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new TranslationRepository($this);
    }
}
