<?php

namespace App;

use App\Repositories\UserCourseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\UserCourse
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property mixed $progress
 * @property string|null $finished_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Course $course
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereUserId($value)
 * @mixin \Eloquent
 * @property int $demo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCourse whereDemo($value)
 */
class UserCourse extends Model
{
    protected $dates = ['finished_at'];

    protected $casts = [
        'progress' => 'array'
    ];

    /**
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo|Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /** @var UserCourseRepository */
    private $repository;

    /**
     * @return UserCourseRepository
     */
    public function repository()
    {
        return isset($this->repository) ? $this->repository : $this->repository = new UserCourseRepository($this);
    }
}
