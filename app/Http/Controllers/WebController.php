<?php

namespace App\Http\Controllers;

use App\Course;
use App\Language;
use App\Level;
use App\Repositories\CourseRepository;
use App\Topic;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $data['courses'] = CourseRepository::all()
            ->join('languages', 'courses.translation_id', '=', 'languages.id')
            ->where('languages.code', 'like', \LaravelLocalization::getCurrentLocale() . '%')
            ->orderBy('level_id')
            ->select('courses.*')
            ->get();

        $data['seo']['title'] = __('web.index.seo.title');
        $data['seo']['description'] = __('web.index.seo.description');
        $data['seo']['keywords'] = __('web.index.seo.keywords');

        return view('index')->with($data);
    }

    public function demo(Request $request, Language $language, Level $level, Topic $topic)
    {
        \Log::info('demo function executed');

        $request->validate([
            'version' => [
                'required', 'integer', 'min:0'
            ]
        ]);

        //ToDo Only published courses
        //ToDo Order by translation native
        $courses = CourseRepository::all()
            ->with(['language', 'level', 'topic', 'translation', 'courseLessons'])
            ->withCount('courseLessons')
            ->where('language_id', $language->id)
            ->where('level_id', $level->id)
            ->where('topic_id', $topic->id)
            ->where('major_version', $request->get('version'))->get();

        if ($courses->isEmpty())
            abort(404);

        $part = 1;

        $data = [];
        $data['language'] = $language->native;
        $data['level'] = $level->name;
        $data['part'] = ($part == 1) ? 'A' : 'B';
//        $data['title'] = $language->native . ' ' . $level->name;

        foreach ($courses as $course) {
//            /** @var CourseLesson $demoLesson */
            $demoLesson = $course->courseLessons->where('index', 10)->first();

            $data['translations'][$course->translation->code] = [];
            $translation = &$data['translations'][$course->translation->code];
            $translation['name'] = $course->translation->native;
            $translation['icon'] = $course->translation->icon;
            $translation['lesson'] = $demoLesson->title . ' ' . $demoLesson->index;
            $translation['storage_url'] = $course->audio_storage;
            $translation['review'] = [];
            $translation['review'] = array_merge($translation['review'], $course->repository()->getReview($demoLesson->index - 7, 1));
            $translation['review'] = array_merge($translation['review'], $course->repository()->getReview($demoLesson->index - 3, 1));
            $translation['review'] = array_merge($translation['review'], $course->repository()->getReview($demoLesson->index - 1, 1));
            $translation['exercises'] = $demoLesson->repository()->part(10);
        }

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

        return view('demo')->with($data);
    }
}
