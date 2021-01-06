<?php

namespace App\Http\Controllers;

use App\Library\Firebase;
use App\Repositories\CourseRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['courses'] = CourseRepository::all()
            ->join('languages', 'courses.translation_id', '=', 'languages.id')
            ->where('languages.code', 'like', \LaravelLocalization::getCurrentLocale() . '%')
            ->orderBy('level_id')
            ->select('courses.*')
            ->get();

        $firebase = Firebase::getInstance()->firestoreClient();
        $data["users_count"] = $firebase->collection(Firebase::statistics_collection)
            ->document('users')
            ->snapshot()->data()['count'];

        $data['seo']['title'] = __('web.index.seo.title');
        $data['seo']['description'] = __('web.index.seo.description');
        $data['seo']['keywords'] = __('web.index.seo.keywords');

        return view('index')->with($data);
    }
}
