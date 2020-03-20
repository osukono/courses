<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlayerSettingsRequest;
use App\Language;
use App\Repositories\PlayerSettingsRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerSettingsController extends Controller
{
    /**
     * @param Language $language
     * @return Factory|RedirectResponse|View
     */
    public function create(Language $language)
    {
        $data['language'] = $language;

        if ($data['language']->playerSettings !== null)
            return redirect()->route('admin.languages.index');

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

        $playerSettings = PlayerSettingsRepository::create($request->all(), $language);
        if (isset($language->firebase_id))
            $playerSettings->repository()->updateFirebaseDocument();

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
        $language->playerSettings->repository()->update($request->all());
        if (isset($language->firebase_id))
            $language->playerSettings->repository()->updateFireBaseDocument();

        return redirect()->route('admin.languages.index');
    }
}
