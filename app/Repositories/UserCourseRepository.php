<?php


namespace App\Repositories;


use App\Course;
use App\User;
use App\UserCourse;
use Illuminate\Support\Str;

class UserCourseRepository
{
    /**
     * @var UserCourse $model
     */
    private $model;

    public function __construct(UserCourse $userCourse)
    {
        $this->model = $userCourse;
    }

    /**
     * @param Course $course
     * @param User $user
     * @return UserCourse|null
     */
    public static function find(Course $course, User $user)
    {
        return $course->userCourses()->where('user_id', $user->id)->first();
    }

    public static function create(Course $course, User $user)
    {
        $userCourse = new UserCourse();
        $userCourse->course()->associate($course);
        $userCourse->user()->associate($user);
        $userCourse->progress = [
            'lesson' => 1,
            'part' => 1,
            'key' => Str::uuid()
        ];
        $userCourse->save();

        return $userCourse;
    }

    public function incrementProgress()
    {
        $progress = $this->model->progress;

        if ($progress['part'] == 1) {
            $progress['part'] = 2;
        } else {
            $progress['lesson'] += 1;
            $progress['part'] = 1;
        }

        $progress['key'] = Str::uuid();

        $this->model->progress = $progress;
        $this->model->save();
    }

    public function resetProgress()
    {
        $this->model->progress = [
            'lesson' => 1,
            'part' => 1,
            'key' => Str::uuid()
        ];

        $this->model->save();
    }

    public function model()
    {
        return $this->model;
    }
}
