<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Firebase;
use App\Library\Sidebar;
use App\Repositories\ContentRepository;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['current'] = Sidebar::dashboard;

        $firebase = Firebase::getInstance()->firestoreClient();
        $data['users'] = $firebase->collection(Firebase::users_collection)->documents()->size();
        $data['contents'] = ContentRepository::all()->count();
        $data['courses'] = CourseRepository::all()->count();

        return view('admin.dashboard')->with($data);
    }
}
