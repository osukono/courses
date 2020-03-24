<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function privacy()
    {
        $data['seo']['title'] = __('web.privacy.seo.title');
        $data['seo']['description'] = __('web.privacy.seo.description');
        $data['seo']['keywords'] = __('web.privacy.seo.keywords');

        return view('documents.privacy')->with($data);
    }

    /*public function terms()
    {
        return view('documents.terms')->with($data);
    }*/
}
