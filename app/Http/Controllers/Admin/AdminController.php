<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
//        dd(is_string(env('FIREBASE_URI')));
//        $data['userCount'] = UserRepository::all()->count();
//        $data['userCoursesCount'] = UserCourseRepository::all()->count();

        return view('admin.dashboard');
    }
}
