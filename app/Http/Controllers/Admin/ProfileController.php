<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Library\Sidebar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::profile);
    }

    public function index()
    {
        return view('admin.profile.index')
            ->with(['user' => Auth::getUser()]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        Auth::getUser()->repository()->updateProfile($request->all());

        return redirect()->route('admin.profile')->with('message', 'Profile has successfully been updated.');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        Auth::getUser()->repository()->updatePassword($request->all());

        return redirect()->route('admin.profile')->with('message', 'Password has successfully been updated.');
    }
}
