<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocaleGroupCreateRequest;
use App\Http\Requests\Admin\LocaleGroupUpdateRequest;
use App\Library\Sidebar;
use App\LocaleGroup;
use App\Repositories\LocaleGroupRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LocaleGroupController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::locales);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['localeGroups'] = LocaleGroupRepository::all()->ordered()->get();

        return view('admin.app.locales.groups.index')->with($data);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.app.locales.groups.create');
    }

    /**
     * @param LocaleGroupCreateRequest $request
     * @return RedirectResponse
     */
    public function store(LocaleGroupCreateRequest $request)
    {
        $localeGroup = LocaleGroupRepository::create($request->all());

        return redirect()->route('admin.app.locale.groups.index')
            ->with('message', __('admin.messages.created', ['object' => $localeGroup]));
    }

    /**
     * @param LocaleGroup $localeGroup
     * @return Factory|\Illuminate\View\View
     */
    public function edit(LocaleGroup $localeGroup)
    {
        $data['localeGroup'] = $localeGroup;

        return view('admin.app.locales.groups.edit')->with($data);
    }


    /**
     * @param LocaleGroupUpdateRequest $request
     * @param LocaleGroup $localeGroup
     * @return RedirectResponse
     */
    public function update(LocaleGroupUpdateRequest $request, LocaleGroup $localeGroup)
    {
        $localeGroup->repository()->update($request->all());

        return redirect()->route('admin.app.locale.groups.index');
    }
}
