<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Library\Sidebar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::profile);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function index(): Factory|\Illuminate\View\View
    {
        return view('admin.profile.index')
            ->with(['user' => Auth::getUser()]);
    }

    /**
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Auth::getUser()->repository()->updateProfile($request->all());

        return redirect()->route('admin.profile')->with('message', 'Profile has successfully been updated.');
    }

    /**
     * @param PasswordUpdateRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        Auth::getUser()->repository()->updatePassword($request->all());

        return redirect()->route('admin.profile')->with('message', 'Password has successfully been updated.');
    }
}
