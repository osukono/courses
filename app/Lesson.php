<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\LessonRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Lesson
 *
 * @property int $id
 * @property int $content_id
 * @property string $title
 * @property int $index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Content $content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Language[] $disabled
 * @property-read int|null $disabled_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @method static Builder|Lesson newModelQuery()
 * @method static Builder|Lesson newQuery()
 * @method static \Illuminate\Database\Query\Builder|Lesson onlyTrashed()
 * @method static Builder|Lesson ordered()
 * @method static Builder|Lesson query()
 * @method static Builder|Lesson sequenced($direction = 'asc')
 * @method static Builder|Lesson whereContentId($value)
 * @method static Builder|Lesson whereCreatedAt($value)
 * @method static Builder|Lesson whereDeletedAt($value)
 * @method static Builder|Lesson whereId($value)
 * @method static Builder|Lesson whereIndex($value)
 * @method static Builder|Lesson whereTitle($value)
 * @method static Builder|Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Lesson withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Lesson withoutTrashed()
 * @mixin \Eloquent
 */
class Lesson extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use Sequence;
    use MaxSequence;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $touches = [
        'content'
    ];

    /**
     * @return BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * @return HasMany|Exercise
     */
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
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
            'group' => 'content_id',
            'fieldName' => 'index',
            'orderFrom1' => true
        ];
    }

    private LessonRepository $repository;

    /**
     * @return LessonRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new LessonRepository($this);
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
        return $this->title;
    }
}
