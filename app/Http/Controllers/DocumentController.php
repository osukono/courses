<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function privacy()
    {
        $data['htmlTitle'] = __('web.html.title.privacy');

        return view('documents.privacy')->with($data);
    }

    public function terms()
    {
        $data['htmlTitle'] = __('web.html.title.terms');

        return view('documents.terms')->with($data);
    }
}
