<?php

namespace App\Http\Controllers;

use App\CourseLesson;
use App\Library\StrUtils;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function show(CourseLesson $courseLesson) {
        if ($courseLesson->grammar == null)
            abort(404);

        $data['course'] = $courseLesson->course->language->native;
        $data['title'] = $courseLesson->title;
        $data['previous'] = CourseLesson::where('course_id', '=', $courseLesson->course_id)
            ->whereNotNull('grammar')
            ->where('index', '<', $courseLesson->index)
            ->orderBy('index', 'desc')
            ->first();
        $data['grammar'] = $courseLesson->grammar;
        $data['next'] = CourseLesson::where('course_id', '=', $courseLesson->course_id)
            ->whereNotNull('grammar')
            ->where('index', '>', $courseLesson->index)
            ->orderBy('index')
            ->first();

        $data['seo']['title'] = $courseLesson->course->language->native . ' - ' . $courseLesson->title;
        $data['seo']['description'] = StrUtils::toPlainText($courseLesson->description);

        return view('grammar')->with($data);
    }
}
