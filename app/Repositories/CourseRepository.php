<?php


namespace App\Repositories;


use App\Content;
use App\Course;
use App\Language;
use App\Level;
use Illuminate\Database\Eloquent\Builder;

class CourseRepository
{
    /** @var Course $model */
    private $model;

    public function __construct(Course $course)
    {
        $this->model = $course;
    }

    /**
     * @param $id
     * @return CourseRepository
     */
    public static function find($id)
    {
        return Course::findOrFail($id)->repository();
    }

    public static function findOrCreate(Language $language, Language $translation, Level $level)
    {
        $course = Course::where('language_id', $language->id)
            ->where('translation_id', $translation->id)
            ->where('level_id', $level->id)->first();

        if ($course == null) {
            $course = new Course();
            $course->language()->associate($language);
            $course->translation()->associate($translation);
            $course->level()->associate($level);
            $course->save();
        }

        return $course;
    }

    /**
     * @return Course|Builder
     */
    public static function all()
    {
        return Course::query();
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->description = $attributes['description'];
        $this->model->demo_lessons = $attributes['demo_lessons'];
        $this->model->price = $attributes['price'];
        $this->model->published = isset($attributes['published']);
        $this->model->save();
    }

    public function getReview($number, $part)
    {
        if ($number <= 0)
            return [];

        $lesson = $this->model->latestContent->courseLessons()->where('number', $number)->first();

        if ($lesson == null)
            return [];

        $exercises = $lesson->repository()->part($part);

        if (count($exercises) == 0)
            return [];
        if (count($exercises) == 1)
            return $exercises;

        $rand_keys = array_rand($exercises, count($exercises) / 2);

        return array_values(array_intersect_key($exercises, array_flip($rand_keys)));
    }

    /**
     * @return Course
     */
    public function model()
    {
        return $this->model;
    }
}
