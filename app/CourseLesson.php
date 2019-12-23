<?php

namespace App;

use App\Library\Eloquent\MaxSequence;
use App\Repositories\CourseLessonRepository;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\CourseLesson
 *
 * @property int $id
 * @property int $course_content_id
 * @property string $title
 * @property int $number
 * @property string $uuid
 * @property string $checksum
 * @property int $demo
 * @property mixed $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\CourseContent $courseContent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereCourseContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereUuid($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson sequenced($direction = 'asc')
 * @property int $exercises_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourseLesson whereExercisesCount($value)
 */
class CourseLesson extends Model
{
    use Sequence;
    use MaxSequence;

    protected $casts = [
        'content' => 'array'
    ];

    /**
     * @return BelongsTo|CourseContent
     */
    public function courseContent()
    {
        return $this->belongsTo(CourseContent::class);
    }

    /**
     * Return the sequence configuration array for this model.
     *
     * @return array
     */
    public function sequence()
    {
        return [
            'group' => 'course_content_id',
            'fieldName' => 'number',
            'orderFrom1' => true
        ];
    }

    /** @var CourseLessonRepository */
    private $repository;

    /**
     * @return CourseLessonRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new CourseLessonRepository($this);
    }
}
