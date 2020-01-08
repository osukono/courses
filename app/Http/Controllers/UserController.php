<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function unsubscribe()
    {
        return view('user.unsubscribe');
    }

    public function saveSettings(SaveSettingsRequest $request)
    {
        $user = \Auth::getUser();

        Log::alert('volume ' . $request->get('volume'));
        Log::alert('speed ' . $request->get('speed'));

        if ($request->has('volume'))
            $user->update(['settings->volume' => $request->get('volume')]);
        if ($request->has('speed'))
            $user->update(['settings->speed' => $request->get('speed')]);
    }
}
