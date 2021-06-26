<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Repositories\ContentRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Content
 *
 * @property int $id
 * @property int $language_id
 * @property int $level_id
 * @property int $topic_id
 * @property string|null $title
 * @property int $version
 * @property int $player_version
 * @property int $review_exercises
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $editors
 * @property-read int|null $editors_count
 * @property-read \App\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\Altek\Accountant\Models\Ledger[] $ledgers
 * @property-read int|null $ledgers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @property-read \App\Level $level
 * @property-read \App\Topic $topic
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content hasAccess(\App\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content wherePlayerVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereReviewExercises($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Content withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $capitalized_words
 * @method static Builder|Content whereCapitalizedWords($value)
 */
class Content extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use Sequence;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @return BelongsTo|Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return BelongsTo|Level
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * @return BelongsTo|Topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * @return HasMany|Lesson
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * @return MorphToMany|User
     */
    public function editors()
    {
        return $this->morphToMany(User::class, 'accessible');
    }

    public function sequence()
    {
        return [
            'group' => [
                'language_id',
                'level_id',
                'topic_id'
            ],
            'fieldName' => 'version',
            'orderFrom1' => true,
            'notUpdateOnDelete' => true,
        ];
    }

    private ContentRepository $repository;

    /**
     * @return ContentRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new ContentRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder|Content
     */
    public function scopeOrdered($query)
    {
        return $query->join('languages', 'contents.language_id', '=', 'languages.id')
            ->join('levels', 'contents.level_id', '=', 'levels.id')
            ->join('topics', 'contents.topic_id', '=', 'topics.id')
            ->orderBy('languages.name')
            ->orderBy('levels.scale')
            ->orderBy('topics.name')
            ->orderBy('version')
            ->select('contents.*');
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeHasAccess(Builder $query, User $user)
    {
        return $user->isAdmin() ? $query : $query->whereHas('editors', function (Builder $query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->language . ' ' . $this->level . ' [' . $this->topic . '] v.' . $this->version;
    }
}
