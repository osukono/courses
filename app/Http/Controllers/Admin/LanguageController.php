<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageCreateRequest;
use App\Http\Requests\Admin\LanguageUpdateRequest;
use App\Http\Requests\Admin\LanguageUploadIconRequest;
use App\Language;
use App\Repositories\LanguageRepository;
use App\Repositories\PlayerSettingsRepository;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
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
        $language = LanguageRepository::create($request->all());
        $language->repository()->createFirestoreDocument();

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
        //ToDo update slugs
        $language->repository()->update($request->all());
        $language->repository()->updateFirestoreDocument();

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
        } catch (FileNotFoundException $e) {
        }

        return redirect()->route('admin.languages.index');
    }

    /**
     * @param Language $language
     * @throws Exception
     */
    public static function validateLanguage(Language $language)
    {
        if (empty($language->firebase_id))
            throw new Exception("Language " . $language . " doesn't have a firebase reference.");
        if (empty($language->icon))
            throw new Exception("Language " . $language . " doesn't have an icon.");
    }

    /**
     * @param Language $language
     * @return RedirectResponse
     */
    public function sync(Language $language)
    {
        try {
            $language->repository()->syncWithFirestore();
            PlayerSettingsRepository::syncWithFirebase($language);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
