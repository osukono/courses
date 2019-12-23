<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\ExerciseRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Exercise
 *
 * @property int $id
 * @property int $lesson_id
 * @property mixed $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ExerciseField[] $exerciseFields
 * @property-read int|null $exercise_fields_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Exercise withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Exercise withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property int $index
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exercise whereIndex($value)
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
     * @return HasMany|ExerciseField
     */
    public function exerciseFields()
    {
        return $this->hasMany(ExerciseField::class);
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

    /** @var ExerciseRepository */
    private $repository;

    /**
     * @return ExerciseRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new ExerciseRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query) {
        return $query->orderBy('index');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Exercise ' . $this->index;
    }
}
