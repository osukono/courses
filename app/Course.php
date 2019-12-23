<?php

namespace App;

use App\Library\Eloquent\MaxSequence;
use App\Repositories\CourseRepository;
use Cviebrock\EloquentSluggable\Sluggable;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Course
 *
 * @property int $id
 * @property int $language_id
 * @property int $translation_id
 * @property int $level_id
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseContent[] $courseContents
 * @property-read int|null $course_contents_count
 * @property-read \App\Language $language
 * @property-read \App\Level $level
 * @property-read \App\Language $translation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course ordered()
 * @property-read \App\CourseContent $latestContent
 * @property string|null $description
 * @property int $demo_lessons
 * @property float $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDemoLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePrice($value)
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereSlug($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserCourse[] $userCourses
 * @property-read int|null $user_courses_count
 * @property-read bool $free
 */
class Course extends Model
{
    use Sluggable;

    protected $casts = [
        'published' => 'boolean'
    ];

    /**
     * @return BelongsTo|Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return BelongsTo|Language
     */
    public function translation()
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
     * @return HasMany|CourseContent
     */
    public function courseContents()
    {
        return $this->hasMany(CourseContent::class);
    }

    /**
     * @return HasOne|CourseContent
     */
    public function latestContent()
    {
        return $this->hasOne(CourseContent::class)->where('enabled', true)->latest();
    }

    /**
     * @return HasMany|UserCourse
     */
    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    /** @var CourseRepository */
    private $repository;

    /**
     * @return CourseRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new CourseRepository($this);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('language_id')->orderBy('level_id');
    }

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['language.name', 'level.name', 'translation.name']
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function getFreeAttribute()
    {
        return $this->price == 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->language . ' ' . $this->level . ' - ' . $this->translation;
    }
}
