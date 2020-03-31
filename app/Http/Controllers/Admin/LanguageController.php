<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageCreateRequest;
use App\Http\Requests\Admin\LanguageUpdateRequest;
use App\Http\Requests\Admin\LanguageUploadIconRequest;
use App\Language;
use App\Library\Sidebar;
use App\Repositories\FirebaseLanguageRepository;
use App\Repositories\FirebasePlayerSettingsRepository;
use App\Repositories\LanguageRepository;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Kreait\Firebase\Exception\RemoteConfigException;

class LanguageController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::languages);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $data['languages'] = LanguageRepository::all()
            ->with('playerSettings')
            ->ordered()->get();

        return view('admin.languages.index')->with($data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * @param LanguageCreateRequest $request
     * @return RedirectResponse
     */
    public function store(LanguageCreateRequest $request)
    {
        try {
            $language = LanguageRepository::create($request->all());

            FirebaseLanguageRepository::createOrUpdate($language);
            FirebasePlayerSettingsRepository::sync($language);
            FirebaseLanguageRepository::incrementLanguagesVersion();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        } catch (RemoteConfigException $e) {
        }

        return redirect()->route('admin.languages.index');
    }

    /**
     * @param Language $language
     * @return Factory|View
     */
    public function edit(Language $language)
    {
        $data['language'] = $language;

        return view('admin.languages.edit')->with($data);
    }

    /**
     * @param LanguageUpdateRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function update(LanguageUpdateRequest $request, Language $language)
    {
        try {
            $language->repository()->update($request->all());

            if (isset($language->firebase_id)) {
                FirebaseLanguageRepository::update($language);
                FirebaseLanguageRepository::incrementLanguagesVersion();
            }
        } catch (RemoteConfigException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.languages.index');
    }

    /**
     * @param LanguageUploadIconRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function uploadIcon(LanguageUploadIconRequest $request, Language $language)
    {
        try {
            $language->repository()->uploadIcon($request);

            if (isset($language->firebase_id)) {
                FirebaseLanguageRepository::updateIconProperty($language);
                FirebaseLanguageRepository::incrementLanguagesVersion();
            }
        } catch (FileNotFoundException $e) {
        } catch (Exception $e) {
        } catch (RemoteConfigException $e) {
        }

        return redirect()->route('admin.languages.index');
    }

    /**
     * @param Language $language
     * @return RedirectResponse
     */
    public function sync(Language $language)
    {
        try {
            FirebaseLanguageRepository::createOrUpdate($language);
            FirebaseLanguageRepository::syncIconProperty($language);
            FirebasePlayerSettingsRepository::sync($language);
            FirebaseLanguageRepository::incrementLanguagesVersion();
        } catch (Exception $e) {
        } catch (RemoteConfigException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
