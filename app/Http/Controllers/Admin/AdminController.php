<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Firebase;
use App\Library\Sidebar;
use App\Repositories\CourseRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return Factory|View
     */
    public function dashboard()
    {
        $data['current'] = Sidebar::dashboard;

        $firebase = Firebase::getInstance()->firestoreClient();
        $data["users_count"] = $firebase->collection(Firebase::statistics_collection)
            ->document('users')
            ->snapshot()->data()['count'];

        $data['courses_count'] = CourseRepository::all()->where('uploaded_at', '!=', null)->count();

        $data['lessons_learned'] = $firebase->collection(Firebase::statistics_collection)
            ->document('lessons')
            ->snapshot()->data()['learned'];

        return view('admin.dashboard')->with($data);
    }
}
