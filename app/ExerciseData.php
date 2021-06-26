<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\ExerciseDataRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ExerciseData
 *
 * @property int $id
 * @property int $exercise_id
 * @property array $content
 * @property bool $translatable
 * @property int $index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Exercise $exercise
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseData onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereTranslatable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExerciseData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseData withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ExerciseData withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Language[] $disabled
 * @property-read int|null $disabled_count
 */
class ExerciseData extends Model implements Recordable
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
        'translatable' => 'boolean',
        'content' => 'array'
    ];

    protected $fillable = [
        'content->value',
        'content->audio',
        'content->duration',
        'content->extra_chunks',
    ];

    /**
     * @return BelongsTo|Exercise
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * @return HasMany|Translation
     */
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    /**
     * @return MorphToMany|Language
     */
    public function disabled()
    {
        return $this->morphToMany(Language::class, 'disabled', 'disabled_content');
    }

    public function sequence()
    {
        return [
            'group' => 'exercise_id',
            'fieldName' => 'index',
            'orderFrom1' => true
        ];
    }

    private ExerciseDataRepository $repository;

    /**
     * @return ExerciseDataRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new ExerciseDataRepository($this);
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
        return 'Sentence ' . $this->index;
    }
}
