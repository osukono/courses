<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Library\Eloquent\MaxSequence;
use App\Repositories\LessonRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Lesson
 *
 * @property int $id
 * @property int $content_id
 * @property string $uuid
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Content $content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property int $index
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereIndex($value)
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

    /** @var LessonRepository */
    private $repository;

    /**
     * @return LessonRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new LessonRepository($this);
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
        return $this->title;
    }
}
