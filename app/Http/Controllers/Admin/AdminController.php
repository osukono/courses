<?php

namespace App\Http\Controllers\Admin;

use App\ExerciseData;
use App\Http\Controllers\Controller;
use App\Library\Firebase;
use App\Library\Sidebar;
use App\Repositories\CourseRepository;
use App\Translation;
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

        try {
            $firebase = Firebase::getInstance()->firestoreClient();

            $data["users_count"] = $firebase->collection(Firebase::statistics_collection)
                ->document('users')
                ->snapshot()->data()['count'];
            $data['lessons_learned'] = $firebase->collection(Firebase::statistics_collection)
                ->document('lessons')
                ->snapshot()->data()['learned'];
        } catch (\Exception $ex) {
            $data['users_count'] = 0;
            $data['lessons_learned'] = 0;
        }

        $data['courses_count'] = CourseRepository::all()->where('uploaded_at', '!=', null)->count();

        //ToDo: created_at == updated_at?
        $data['devActivity'] =
            ExerciseData::whereRaw('(updated_at >= DATE(NOW()) - INTERVAL 1 MONTH) OR (created_at >= DATE(NOW()) - INTERVAL 1 MONTH)')->count() +
            Translation::whereRaw('(updated_at >= DATE(NOW()) - INTERVAL 1 MONTH) OR (created_at >= DATE(NOW()) - INTERVAL 1 MONTH)')->count();

        return view('admin.dashboard')->with($data);
    }
}
