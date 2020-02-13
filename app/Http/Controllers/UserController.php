<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function unsubscribe()
    {
        $user = \Auth::getUser();

        $user->update((['subscribed' => false]));

        return view('user.unsubscribe');
    }

    public function saveSettings(SaveSettingsRequest $request)
    {
        $user = \Auth::getUser();

        if ($request->has('volume'))
            $user->update(['settings->volume' => $request->get('volume')]);
        if ($request->has('speed'))
            $user->update(['settings->speed' => $request->get('speed')]);
    }
}
