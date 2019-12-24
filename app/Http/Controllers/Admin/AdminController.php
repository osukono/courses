<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserCourseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['userCount'] = UserRepository::all()->count();
        $data['userCoursesCount'] = UserCourseRepository::all()->count();

        return view('admin.dashboard')->with($data);
    }
}
