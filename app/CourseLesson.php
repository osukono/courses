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
 * @property string|null $image
 * @property string|null $description
 * @property string|null $grammar
 * @property int $exercises_count
 * @property array $content
 * @property int $index
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson sequenced($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereExercisesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereGrammar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseLesson withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
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
