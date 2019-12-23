<?php

namespace App;

use App\Repositories\CourseContentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\CourseContent
 *
 * @property int $id
 * @property int $course_id
 * @property string $description
 * @property int $published
 * @property int $demo_lessons
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseLesson[] $courseLessons
 * @property-read int|null $course_lessons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereDemoLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $enabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseContent whereEnabled($value)
 */
class CourseContent extends Model
{
    /**
     * @return BelongsTo|Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return HasMany|CourseLesson
     */
    public function courseLessons()
    {
        return $this->hasMany(CourseLesson::class);
    }

    /** @var CourseContentRepository */
    private $repository;

    /**
     * @return CourseContentRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new CourseContentRepository($this);
    }
}
