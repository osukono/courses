<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $data['courses'] = CourseRepository::all()->where('published', true)->get();
        $data['htmlTitle'] = __('web.html.title.index');

        return view('index')->with($data);
    }

    public function seed()
    {
        (new \DatabaseSeeder())->run();
    }
}
