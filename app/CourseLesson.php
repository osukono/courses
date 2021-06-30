<?php

namespace App;

use App\Library\Eloquent\MaxSequence;
use App\Repositories\CourseLessonRepository;
use Cviebrock\EloquentSluggable\Sluggable;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\CourseLesson
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property int $exercises_count
 * @property array $content
 * @property int $index
 * @property-read \App\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereExercisesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereTitle($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereUpdatedAt($value)
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereImage($value)
 * @property string|null $grammar
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereGrammar($value)
 */
class CourseLesson extends Model
{
    use Sequence;
    use MaxSequence;
    use Sluggable;

    protected $casts = [
        'content' => 'array'
    ];

    /**
     * @return BelongsTo|Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Return the sequence configuration array for this model.
     *
     * @return array
     */
    public function sequence()
    {
        return [
            'group' => 'course_id',
            'fieldName' => 'index',
            'orderFrom1' => true
        ];
    }

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['course_id', 'title']
            ]
        ];
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    private CourseLessonRepository $repository;

    /**
     * @return CourseLessonRepository
     */
    public function repository()
    {
        return $this->repository ?? $this->repository = new CourseLessonRepository($this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
