<?php


namespace App\Repositories;


use App\Content;
use App\Course;
use App\Language;
use App\Library\Firebase;
use Exception;
use Google\Cloud\Firestore\FieldValue;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseRepository
{
    private Course $model;

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

    public static function findOrCreate(Content $content, Language $translation)
    {
        /** @var Course $course */
        $course = Course::where('language_id', $content->language->id)
            ->where('translation_id', $translation->id)
            ->where('level_id', $content->level->id)
            ->where('topic_id', $content->topic->id)
            ->where('major_version', $content->version)->first();

        if ($course == null) {
            $course = new Course();
            $course->language()->associate($content->language);
            $course->translation()->associate($translation);
            $course->level()->associate($content->level);
            $course->topic()->associate($content->topic);
            $course->major_version = $content->version;
            $course->minor_version = 0;
            $course->save();
        }

        $course->title = $content->title;
        $course->description = $content->description;
        $course->player_version = $content->player_version;
        $course->review_exercises = $content->review_exercises;
        $course->save();

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
        $this->model->title = $attributes['title'];
        $this->model->description = $attributes['description'];
        $this->model->review_exercises = $attributes['review_exercises'];
        $this->model->android_product_id = $attributes['android_product_id'];
        $this->model->ios_product_id = $attributes['ios_product_id'];
        $this->model->demo_lessons = $attributes['demo_lessons'];
        $this->model->minor_version = $attributes['version'];
        $this->model->firebase_id = $attributes['firebase_id'];
        $this->model->save();
    }

    public function getReview($number, $part)
    {
        if ($number <= 0)
            return [];

        $lesson = $this->model->courseLessons()->where('index', $number)->first();

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
     * @param Request $request
     * @throws FileNotFoundException
     */
    public function uploadImage(Request $request)
    {
        $image = Firebase::getInstance()->uploadFile($request->file('image'), 'courses');

        $this->model->image = $image;
        $this->model->save();
    }

    /**
     * @throws Exception
     */
    public function firestoreUpdate()
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $reference = $firestore->collection(Firebase::courses_collection)->document($this->model->firebase_id);

        $reference->set([
            'title' => $this->model->title,
            'description' => $this->model->description,
            'icon' => $this->model->image,
            'demo' => $this->model->demo_lessons,
            'player_version' => $this->model->player_version,
            'review_exercises' => $this->model->review_exercises,
        ], ['merge' => true]);

        Firebase::updateOrDeleteField($reference, 'android_product_id', $this->model->android_product_id);
        Firebase::updateOrDeleteField($reference, 'ios_product_id', $this->model->ios_product_id);
    }

    /**
     * @throws Exception
     */
    public function switchIsUpdating()
    {
        if (!isset($this->model->firebase_id))
            throw new Exception($this->model . '. Firebase ID is not set.');

        FirebaseCourseRepository::setIsUpdating($this->model, !$this->model->is_updating);

        $this->model->is_updating = !$this->model->is_updating;
        $this->model->save();
    }

    /**
     * @return Course
     */
    public function model()
    {
        return $this->model;
    }
}
