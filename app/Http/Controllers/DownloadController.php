<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DownloadController extends Controller
{
    public function index() {
        if ($this->isAppleDevice())
            return redirect()->to(__('web.index.section.app.links.ios'));
        else
            return redirect()->to(__('web.index.section.app.links.android'));
    }

    private function isAppleDevice() {
        $agent = new Agent();

        return $agent->platform() == "OS X" or $agent->platform() == "iOS"
            or $agent->platform() == "iPadOS";
    }
}
