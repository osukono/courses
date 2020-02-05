<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\AudioDuration;
use App\Http\Controllers\Controller;
use App\Library\Audio;
use App\Repositories\UserCourseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['userCount'] = UserRepository::all()->count();
        $data['userCoursesCount'] = UserCourseRepository::all()->count();

        return view('admin.dashboard')->with($data);
    }

    public function test()
    {
        dd(Audio::length("https://yummy-lingo.s3.eu-central-1.amazonaws.com/6eAaxRZio6WU8ab1DhyrcdZ5RHdg7IB0eXuh0xBy.wav"));
    }
}
