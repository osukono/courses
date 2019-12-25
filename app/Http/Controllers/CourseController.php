<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function practice(Course $course)
    {
        $user = Auth::user();

        $userCourse = $user->repository()->getUserCourse($course);

        /**
         * Course is not published and user hasn't started it before.
         */
        abort_if($userCourse == null && !$course->published, 404);

        /**
         * User hasn't started the course.
         */
        if ($userCourse == null) {
            $userCourse = $user->repository()->enroll($course);
        }

        $courseLesson = $course->latestContent->courseLessons()->where('number', $userCourse->progress['lesson'])->first();

        /**
         * User has finished the course.
         */
        if ($courseLesson == null) {
            return redirect()->route('home');
        }

        /**
         * User has finished all of the demo lessons.
         */
        if ($userCourse->demo && $courseLesson->number > $course->demo_lessons) {
            //ToDo Temporary
            return redirect()->route('home');
        }

        $review = [];

        $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 7, $userCourse->progress['part']));
        $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 3, $userCourse->progress['part']));
        $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 1, $userCourse->progress['part']));

//        if ($userCourse->progress['part'] == 1) {
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 4, 2));
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 2, 2));
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 1, 2));
//        } else if ($userCourse->progress['part'] == 2) {
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 3, 1));
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'] - 1, 1));
//            $review = array_merge($review, $userCourse->course->repository()->getReview($userCourse->progress['lesson'], 1));
//        }

        $data['exercises'] = $courseLesson->repository()->part($userCourse->progress['part']);
        $data['review'] = $review;
        $data['course'] = $course;
        $data['key'] = $userCourse->progress['key'];
        $data['title'] = $courseLesson->title . ' › ' . __('Part') . ' ' . $userCourse->progress['part'];
        $data['locale'] = $this->getPlayerLocale();

        $data['htmlTitle'] = $data['title'];

        return view('courses.practice')->with($data);
    }

    public function practiceLesson(Course $course, $number)
    {
        $user = Auth::user();

        $userCourse = $user->repository()->getUserCourse($course);

        abort_if($userCourse == null, 404);
        abort_if($userCourse->demo && $userCourse->course->demo_lessons < $number, 404);
        abort_if($userCourse->progress['lesson'] <= $number, 404);
        abort_if($course->latestContent->courseLessons->max('number') < $number, 404);

        $courseLesson = $course->latestContent->courseLessons()->where('number', $number)->first();

        $data['review'] = $courseLesson->content['exercises'];
        $data['title'] = $courseLesson->title . ' › ' . __('Review');
        $data['locale'] = $this->getPlayerLocale();

        $data['htmlTitle'] = $data['title'];

        return view('courses.review')->with($data);
    }

    public function updateProgress(Course $course, $key)
    {
        $user = Auth::user();

        $userCourse = $user->repository()->getUserCourse($course);

        abort_if($userCourse == null, 404);
        abort_if($userCourse->progress['key'] !== $key, 410);

        $userCourse->repository()->incrementProgress();

        return response('OK', 200)
            ->header('Content-Type', 'text/plain');
    }

    public function resetProgress(Course $course)
    {
        $user = Auth::user();

        $userCourse = $user->repository()->getUserCourse($course);

        abort_if($userCourse == null, 404);

        $userCourse->repository()->resetProgress();

        return redirect()->route('home');
    }

    public function examples(Course $course, $number)
    {
        abort_if($course->latestContent->courseLessons->max('number') < $number, 404);

        $courseLesson = $course->latestContent->courseLessons()->where('number', $number)->first();

        $data['course'] = $course;
        $data['title'] = $courseLesson->title;
        $data['exercises'] = $courseLesson->content['exercises'];
        $data['htmlTitle'] = $course->language . ' ' . $course->level . ' / ' . $courseLesson->title;

        return view('courses.examples')->with($data);
    }

    private function getPlayerLocale()
    {
        return [
            'start' => __('Start'),
            'pause' => __('Pause'),
            'resume' => __('Resume'),
            'repeat' => __('Repeat'),
            'continue' => __('Continue'),
            'practice' => __('Practice'),
            'instruction' => __('web.player.instruction'),
            'progress.fail' => __('web.player.progress.fail')
        ];
    }
}
