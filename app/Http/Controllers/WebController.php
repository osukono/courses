<?php

namespace App\Http\Controllers;

use App\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $data['courses'] = CourseRepository::all()->whereIn('id', Course::selectRaw('min(id)')
            ->groupBy(['language_id', 'level_id', 'topic_id', 'major_version']))
            ->ordered()
            ->get();

//        dd($data['courses']);

        $data['seo']['title'] = __('web.index.seo.title');
        $data['seo']['description'] = __('web.index.seo.description');
        $data['seo']['keywords'] = __('web.index.seo.keywords');

        return view('index')->with($data);
    }
}
