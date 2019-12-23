<?php


namespace App\Repositories;


use App\Course;
use App\CourseContent;

class CourseContentRepository
{
    /** @var CourseContent $model */
    private $model;

    public function __construct(CourseContent $courseContent)
    {
        $this->model = $courseContent;
    }

    public static function create(Course $course)
    {
        $courseContent = new CourseContent();
        $courseContent->course()->associate($course);
        $courseContent->save();

        return $courseContent;
    }

    public function enable()
    {
        $this->model->enabled = true;
        $this->model->save();
    }

    public function model()
    {
        return $this->model;
    }
}
