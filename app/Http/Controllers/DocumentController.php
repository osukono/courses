<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function privacy()
    {
        $data['seo']['title'] = __('web.privacy.seo.title');
        $data['seo']['description'] = __('web.privacy.seo.description');
        $data['seo']['keywords'] = __('web.privacy.seo.keywords');

        return view('documents.privacy')->with($data);
    }
}
