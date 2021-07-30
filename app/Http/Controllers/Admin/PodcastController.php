<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Sidebar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PodcastController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::podcasts);
    }

    public function index()
    {
        return redirect()->back();
    }
}
