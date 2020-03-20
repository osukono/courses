<?php


namespace App\Repositories;


use App\CourseLesson;

class CourseLessonRepository
{
    private CourseLesson $model;

    public function __construct(CourseLesson $courseLesson)
    {
        $this->model = $courseLesson;
    }

    public function part($part)
    {
        if ($part == 1)
            return array_slice($this->model->content['exercises'], 0, (int) count($this->model->content['exercises']) / 2);
        if ($part == 2)
            return array_slice($this->model->content['exercises'], (int) count($this->model->content['exercises']) / 2);

        return [];
    }

    /**
     * @return CourseLesson|null
     */
    public function previous()
    {
        return CourseLesson::where('course_id', $this->model->course_id)
            ->where('index', '<', $this->model->index)
            ->orderBy('index', 'desc')->first();
    }

    /**
     * @return CourseLesson|null
     */
    public function next()
    {
        return CourseLesson::where('course_id', $this->model->course_id)
            ->where('index', '>', $this->model->index)
            ->orderBy('index', 'asc')->first();
    }

    public function model()
    {
        return $this->model;
    }
}
