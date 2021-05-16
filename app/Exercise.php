<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\ExerciseRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Exercise
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ExerciseData[] $exerciseData
 * @property-read int|null $exercise_data_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property-read \App\Lesson $lesson
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Exercise onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exercise withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Exercise withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Language[] $disabled
 * @property-read int|null $disabled_count
 */
class Exercise extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use Sequence;
    use MaxSequence;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $touches = [
        'lesson'
    ];

    /**
     * @return BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * @return HasMany|ExerciseData
     */
    public function exerciseData()
    {
        return $this->hasMany(ExerciseData::class);
    }

    /**
     * @return MorphToMany|Language
     */
    public function disabled()
    {
        return $this->morphToMany(Language::class, 'disabled', 'disabled_content');
    }

    /**
     * Return the sequence configuration array for this model.
     *
     * @return array
     */
    public function sequence()
    {
        return [
            'group' => 'lesson_id',
            'fieldName' => 'index',
            'orderFrom1' => true
        ];
    }

    private ExerciseRepository $repository;

    /**
     * @return ExerciseRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new ExerciseRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query) {
        return $query->orderBy('index');
    }

    /**
     * @param Language $language
     * @return bool
     */
    public function isDisabled(Language $language)
    {
        return $this->disabled->where('id', $language->id)->isNotEmpty();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Exercise ' . $this->index;
    }
}
