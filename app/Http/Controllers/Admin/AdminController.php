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
        $data['users'] = $firebase->collection(Firebase::users_collection)
            ->documents()
            ->size();
        $data['courses'] = CourseRepository::all()->where('uploaded_at', '!=', null)->count();

        return view('admin.dashboard')->with($data);
    }
}
