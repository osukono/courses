<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\ExerciseFieldRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ExerciseField
 *
 * @property int $id
 * @property int $exercise_id
 * @property int $field_id
 * @property array $content
 * @property int $index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Exercise $exercise
 * @property-read \App\Field $field
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseField onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseField withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseField withoutTrashed()
 * @mixin \Eloquent
 */
class ExerciseField extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use Sequence;
    use MaxSequence;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $touches = [
        'exercise'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    protected $fillable = [
        'content->value',
        'content->audio'
    ];

    /**
     * @return BelongsTo|Exercise
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * @return BelongsTo|Field
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * @return HasMany|Translation
     */
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function sequence()
    {
        return [
            'group' => 'exercise_id',
            'fieldName' => 'index',
            'orderFrom1' => true
        ];
    }

    /** @var ExerciseFieldRepository */
    private $repository;

    /**
     * @return ExerciseFieldRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new ExerciseFieldRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query) {
        return $query->orderBy('index');
    }

    public function __toString()
    {
        return 'Field ' . $this->index;
    }
}
