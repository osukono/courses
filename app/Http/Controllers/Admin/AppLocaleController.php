<?php

namespace App\Http\Controllers\Admin;

use App\AppLocale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppLocaleCreateRequest;
use App\Http\Requests\Admin\AppLocaleUpdateRequest;
use App\Jobs\LoadLocales;
use App\Jobs\UploadLocales;
use App\Library\Sidebar;
use App\Repositories\AppLocaleRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\LocaleGroupRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AppLocaleController extends Controller
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
        $data['appLocales'] = AppLocaleRepository::all()->with('localeGroup')
            ->ordered()->get();

        return view('admin.app.locales.index')->with($data);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['localeGroups'] = LocaleGroupRepository::all()->ordered()->get();
        $data['languages'] = LanguageRepository::all()->ordered()->get();

        return view('admin.app.locales.create')->with($data);
    }

    /**
     * @param AppLocaleCreateRequest $request
     * @return RedirectResponse
     */
    public function store(AppLocaleCreateRequest $request)
    {
        $appLocale = AppLocaleRepository::create($request->all());

        return redirect()->route('admin.app.locales.index', ['#locale-' . $appLocale->id])
            ->with('messages', __('admin.messages.created', ['object' => $appLocale]));
    }

    /**
     * @param AppLocale $appLocale
     * @return Factory|\Illuminate\View\View
     */
    public function edit(AppLocale $appLocale)
    {
        $data['appLocale'] = $appLocale;
        $data['localeGroups'] = LocaleGroupRepository::all()->ordered()->get();
        $data['languages'] = LanguageRepository::all()->ordered()->get();

        return view('admin.app.locales.edit')->with($data);
    }

    /**
     * @param AppLocaleUpdateRequest $request
     * @param AppLocale $appLocale
     * @return RedirectResponse
     */
    public function update(AppLocaleUpdateRequest $request, AppLocale $appLocale)
    {
        $appLocale->repository()->update($request->all());

        return redirect()->route('admin.app.locales.index', ['#locale-' . $appLocale->id]);
    }

    /**
     * @param AppLocale $appLocale
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(AppLocale $appLocale)
    {
        $appLocale->delete();

        return redirect()->route('admin.app.locales.index')
            ->with('message', __('admin.messages.deleted.success', ['object' => $appLocale]));
    }

    /**
     * @return RedirectResponse
     */
    public function download()
    {
        $this->dispatchJob(new LoadLocales(), route('admin.app.locales.index'));

        return redirect()->route('admin.app.locales.index');
    }

    /**
     * @return RedirectResponse
     */
    public function upload()
    {
        $this->dispatchJob(new UploadLocales(), route('admin.app.locales.index'));

        return redirect()->route('admin.app.locales.index');
    }
}
