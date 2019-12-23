<?php

namespace App;

use Altek\Accountant\Contracts\Recordable;
use App\Repositories\ContentRepository;
use Cviebrock\EloquentSluggable\Sluggable;
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
 * @property string|null $description
 * @property int $demo_lessons
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDemoLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Content withoutTrashed()
 * @mixin \Eloquent
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereSlug($value)
 */
class Content extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use SoftDeletes;
    use Sluggable;

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

    /** @var ContentRepository */
    private $repository;

    /**
     * @return ContentRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new ContentRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder|Content
     */
    public function scopeOrdered($query)
    {
        return $query->join('languages', 'contents.language_id', '=', 'languages.id')
            ->join('levels', 'contents.level_id', '=', 'levels.id')
            ->orderBy('languages.name')
            ->orderBy('levels.scale')
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['language.name', 'level.name']
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->language . ' ' . $this->level;
    }
}
