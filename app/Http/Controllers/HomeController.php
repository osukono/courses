<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $data['userCourses'] = Auth::user()->userCourses()
            ->with([
                'course',
                'course.latestContent' => function (HasOne $query) {
                    $query->withCount('courseLessons');
                },
            ])
            ->latest('updated_at')->get();

        $data['courses'] = CourseRepository::all()->where('published', true)
            ->whereNotIn('id', $data['userCourses']->pluck('course_id'))->get();

        $data['htmlTitle'] = __('web.html.title.home');

        return view('home')->with($data);
    }
}
