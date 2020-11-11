<?php

namespace App;

use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Course
 *
 * @property int $id
 * @property int $language_id
 * @property int $translation_id
 * @property int $level_id
 * @property int $topic_id
 * @property string|null $title
 * @property string|null $description
 * @property int $major_version
 * @property int $minor_version
 * @property int $player_version
 * @property bool $published
 * @property string|null $image
 * @property int $review_exercises
 * @property string|null $audio_storage
 * @property string|null $firebase_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $committed_at
 * @property \Illuminate\Support\Carbon|null $uploaded_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseLesson[] $courseLessons
 * @property-read int|null $course_lessons_count
 * @property-read \App\Language $language
 * @property-read \App\Level $level
 * @property-read \App\Topic $topic
 * @property-read \App\Language $translation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereAudioStorage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCommittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereMajorVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereMinorVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePlayerVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereReviewExercises($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUploadedAt($value)
 * @mixin \Eloquent
 * @property int $is_updating
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereIsUpdating($value)
 * @property string|null $android_product_id
 * @property string|null $ios_product_id
 * @property string $demo_lessons
 * @method static Builder|Course whereAndroidProductId($value)
 * @method static Builder|Course whereDemoLessons($value)
 * @method static Builder|Course whereIosProductId($value)
 */
class Course extends Model
{
    protected $dates = [
        'committed_at',
        'uploaded_at',
        'published_at'
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
     * @return BelongsTo|Topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * @return HasMany|CourseLesson
     */
    public function courseLessons()
    {
        return $this->hasMany(CourseLesson::class);
    }

    private CourseRepository $repository;

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
        // ToDo proper ordering
        return $query->orderBy('language_id')
            ->orderBy('level_id')->orderBy('topic_id')->orderBy('major_version');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->language . ' ' . $this->level . ' [' . $this->topic . ']' . ' - ' . $this->translation . ' v' . $this->major_version . '.' . $this->minor_version;
    }
}
