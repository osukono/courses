<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlayerSettingsRequest;
use App\Language;
use App\Repositories\FirebaseLanguageRepository;
use App\Repositories\FirebasePlayerSettingsRepository;
use App\Repositories\PlayerSettingsRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Kreait\Firebase\Exception\RemoteConfigException;

class PlayerSettingsController extends Controller
{
    /**
     * @param Language $language
     * @return Factory|RedirectResponse|View
     */
    public function create(Language $language)
    {
        if ($language->playerSettings !== null)
            return redirect()->route('admin.languages.index');

        $data['language'] = $language;

        return view('admin.player.settings.create')->with($data);
    }

    /**
     * @param PlayerSettingsRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function store(PlayerSettingsRequest $request, Language $language)
    {
        if ($language->playerSettings !== null)
            return redirect()->route('admin.languages.index');

        try {
            PlayerSettingsRepository::create($request->all(), $language);

            if (isset($language->firebase_id)) {
                //ToDo Seems like a bug
                $language->refresh();
                FirebasePlayerSettingsRepository::sync($language);
                FirebaseLanguageRepository::incrementLanguagesVersion();
            }
        } catch (RemoteConfigException $e) {
            return back()->with('error', $e->getMessage());
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

        return view('admin.player.settings.edit')->with($data);
    }

    /**
     * @param PlayerSettingsRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function update(PlayerSettingsRequest $request, Language $language)
    {
        try {
            $language->playerSettings->repository()->update($request->all());

            if (isset($language->firebase_id)) {
                FirebasePlayerSettingsRepository::sync($language);
                FirebaseLanguageRepository::incrementLanguagesVersion();
            }
        } catch (RemoteConfigException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.languages.index');
    }
}
