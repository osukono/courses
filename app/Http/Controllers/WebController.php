<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $data['courses'] = CourseRepository::all()/*->where('uploaded_at', '!=', null)*/->ordered()->get();
        $data['seo']['title'] = __('web.index.seo.title');
        $data['seo']['description'] = __('web.index.seo.description');
        $data['seo']['keywords'] = __('web.index.seo.keywords');

        return view('index')->with($data);
    }
}
