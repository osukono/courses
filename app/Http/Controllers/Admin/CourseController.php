<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseLesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseUpdateRequest;
use App\Http\Requests\Admin\CourseUploadImageRequest;
use App\Jobs\UploadCourseToFirestore;
use App\Repositories\CourseRepository;
use App\Repositories\FirebaseCourseRepository;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $data['courses'] = CourseRepository::all()
            ->with([
                'language',
                'translation',
                'level'
            ])->withCount('courseLessons')
            ->ordered()->get();

        return view('admin.courses.index')->with($data);
    }

    /**
     * @param Course $course
     * @return Factory|View
     */
    public function show(Course $course)
    {
        $data['course'] = $course;
        $data['lessons'] = $course->courseLessons;

        return view('admin.courses.show')->with($data);
    }

    /**
     * @param Course $course
     * @return Factory|View
     */
    public function edit(Course $course)
    {
        $data['course'] = $course;

        return view('admin.courses.edit')->with($data);
    }

    /**
     * @param CourseUpdateRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course->repository()->update($request->all());

        return redirect()->route('admin.courses.show', $course);
    }

    /**
     * @param CourseUploadImageRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function uploadImage(CourseUploadImageRequest $request, Course $course)
    {
        try {
            $course->repository()->uploadImage($request);
        } catch (FileNotFoundException $e) {
        }

        return back();
    }

    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function firestoreUpload(Course $course)
    {
        try {
            if (!$course->is_updating)
                throw new Exception('Is updating state is not set.');

            LanguageController::validateLanguage($course->language);
            if ($course->language->playerSettings()->doesntExist())
                throw new Exception("Language " . $course->language . " doesn't have player settings.");
            LanguageController::validateLanguage($course->translation);
            TopicController::validateTopic($course->topic);
            CourseController::validateCourse($course);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $job = new UploadCourseToFirestore($course);
        $this->dispatch($job);
        try {
            $jobStatusId = $job->getJobStatusId();
            Session::flash('job', $jobStatusId);
        } catch (Exception $e) {
        }

        return redirect()->route('admin.courses.show', $course);
    }

    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function firestoreUpdate(Course $course)
    {
        try {
            $this->validateCourse($course);

            $course->repository()->firestoreUpdate();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('message', 'Firestore record has successfully been updated.');
    }

    /**
     * @param $course
     * @throws Exception
     */
    public static function validateCourse($course)
    {
        if (empty($course->title))
            throw new Exception("Course " . $course . " doesn't have the title");
        if (empty($course->description))
            throw new Exception("Course " . $course . " doesn't have the description");
        if (empty($course->image))
            throw new Exception("Course " . $course . " doesn't have an image");
        if (empty($course->player_version))
            throw new Exception("Course " . $course . " - player version is not set.");
        if (empty($course->review_exercises))
            throw new Exception("Course " . $course . " - review exercises is not set.");
    }

    public function practice(Course $course, CourseLesson $courseLesson)
    {
        $data['course'] = $course;
        $data['courseLesson'] = $courseLesson;
        $data['previous'] = $courseLesson->repository()->previous();
        $data['next'] = $courseLesson->repository()->next();

        $exercises['part_1']['title'] = __('Lesson') . ' A';
        $exercises['part_1']['review'] = [];
        $exercises['part_1']['review'] = array_merge($exercises['part_1']['review'], $course->repository()->getReview($courseLesson->index - 7, 1));
        $exercises['part_1']['review'] = array_merge($exercises['part_1']['review'], $course->repository()->getReview($courseLesson->index - 3, 1));
        $exercises['part_1']['review'] = array_merge($exercises['part_1']['review'], $course->repository()->getReview($courseLesson->index - 1, 1));
        $exercises['part_1']['exercises'] = $courseLesson->repository()->part(1);

        $exercises['part_2']['title'] = __('Lesson') . ' B';
        $exercises['part_2']['review'] = [];
        $exercises['part_2']['review'] = array_merge($exercises['part_2']['review'], $course->repository()->getReview($courseLesson->index - 7, 2));
        $exercises['part_2']['review'] = array_merge($exercises['part_2']['review'], $course->repository()->getReview($courseLesson->index - 3, 2));
        $exercises['part_2']['review'] = array_merge($exercises['part_2']['review'], $course->repository()->getReview($courseLesson->index - 1, 2));
        $exercises['part_2']['exercises'] = $courseLesson->repository()->part(2);

        $exercises['review']['title'] = __('Review');
        $exercises['review']['exercises'] = $courseLesson->content['exercises'];

        $data['exercises'] = $exercises;
        $data['title'] = $courseLesson->title;
        $data['locale'] = [
            'start' => __('Start'),
            'pause' => __('Pause'),
            'resume' => __('Resume'),
            'repeat' => __('Repeat'),
            'practice' => __('Practice'),
            'instruction' => __('web.player.instruction'),
            'speed.slower' => __('web.player.speed.slower'),
            'speed.normal' => __('web.player.speed.normal'),
            'speed.faster' => __('web.player.speed.faster')
        ];

        return view('admin.courses.practice')->with($data);
    }

    public function switchIsUpdating(Course $course)
    {
        try {
            $course->repository()->switchIsUpdating();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.courses.show', $course);
    }

    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function delete(Course $course)
    {
        try {
            $course->courseLessons()->delete();
            $course->delete();
        } catch (Exception $e) {
        }

        return redirect()->route('admin.courses.index');
    }
}
