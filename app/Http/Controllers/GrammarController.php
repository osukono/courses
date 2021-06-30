<?php

namespace App\Http\Controllers;

use App\CourseLesson;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function show(CourseLesson $courseLesson) {
        if ($courseLesson->grammar == null)
            abort(404);

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

        return view('grammar')->with($data);
    }
}
