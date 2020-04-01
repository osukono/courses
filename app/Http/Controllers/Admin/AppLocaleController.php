<?php

namespace App\Http\Controllers\Admin;

use App\AppLocale;
use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Session;
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
     * @return RedirectResponse
     */
    public function download()
    {
        $job = new LoadLocales();
        $this->dispatch($job);
        try {
            $jobStatusId = $job->getJobStatusId();
            Session::flash('job', $jobStatusId);
        } catch (Exception $e) {
        }

        return redirect()->route('admin.app.locales.index');
    }

    /**
     * @return RedirectResponse
     */
    public function upload()
    {
        $job = new UploadLocales();
        $this->dispatch($job);
        try {
            $jobStatusId = $job->getJobStatusId();
            Session::flash('job', $jobStatusId);
        } catch (Exception $e) {
        }

        return redirect()->route('admin.app.locales.index');
    }
}
