<?php

namespace App\Http\Controllers;

use App\CourseLesson;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function show(CourseLesson $courseLesson) {
        if ($courseLesson->grammar == null)
            abort(404);

        $data['grammar'] = $courseLesson->grammar;

        return view('grammar')->with($data);
    }
}
