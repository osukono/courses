<?php


namespace App\Repositories;


use App\Course;
use App\User;
use App\UserCourse;

class UserRepository
{
    /** @var User $model */
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param Course $course
     * @return UserCourse|null
     */
    public function getUserCourse(Course $course)
    {
        return UserCourseRepository::find($course, $this->model);
    }

    /**
     * @param Course $course
     * @return UserCourse
     */
    public function enroll(Course $course) {
        return UserCourseRepository::create($course, $this->model);
    }

    /**
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }
}
