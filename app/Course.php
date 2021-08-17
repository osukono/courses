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
 * @property string|null $image
 * @property string|null $android_product_id
 * @property string|null $ios_product_id
 * @property string|null $ad_mob_banner_unit_id_android
 * @property string|null $ad_mob_banner_unit_id_ios
 * @property int $demo_lessons
 * @property string|null $audio_storage
 * @property string|null $capitalized_words
 * @property string|null $firebase_id
 * @property int $is_updating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $committed_at
 * @property \Illuminate\Support\Carbon|null $uploaded_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseLesson[] $courseLessons
 * @property-read int|null $course_lessons_count
 * @property-read \App\Language $language
 * @property-read \App\Level $level
 * @property-read \App\Topic $topic
 * @property-read \App\Language $translation
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course ordered()
 * @method static Builder|Course query()
 * @method static Builder|Course whereAdMobBannerUnitIdAndroid($value)
 * @method static Builder|Course whereAdMobBannerUnitIdIos($value)
 * @method static Builder|Course whereAndroidProductId($value)
 * @method static Builder|Course whereAudioStorage($value)
 * @method static Builder|Course whereCapitalizedWords($value)
 * @method static Builder|Course whereCommittedAt($value)
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereDemoLessons($value)
 * @method static Builder|Course whereDescription($value)
 * @method static Builder|Course whereFirebaseId($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereImage($value)
 * @method static Builder|Course whereIosProductId($value)
 * @method static Builder|Course whereIsUpdating($value)
 * @method static Builder|Course whereLanguageId($value)
 * @method static Builder|Course whereLevelId($value)
 * @method static Builder|Course whereMajorVersion($value)
 * @method static Builder|Course whereMinorVersion($value)
 * @method static Builder|Course wherePlayerVersion($value)
 * @method static Builder|Course whereTitle($value)
 * @method static Builder|Course whereTopicId($value)
 * @method static Builder|Course whereTranslationId($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @method static Builder|Course whereUploadedAt($value)
 * @mixin \Eloquent
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
        return $this->repository ?? $this->repository = new CourseRepository($this);
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
