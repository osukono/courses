<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpeechSettingsUpdateRequest;
use App\Language;
use App\Library\Sidebar;
use App\Repositories\SpeechSettingsRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpeechSettingsController extends Controller
{
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('current', Sidebar::courses);
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function editContentSettings(Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;
        $data['speechSettings'] = SpeechSettingsRepository::find($content, $content->language);

        return view('admin.development.speech.settings')->with($data);
    }

    /**
     * @param SpeechSettingsUpdateRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateContentSettings(SpeechSettingsUpdateRequest $request, Content $content)
    {
        $this->authorize('access', $content);

        SpeechSettingsRepository::createOrUpdate($content, $content->language, $request->all());

        return redirect()->route('admin.dev.courses.show', $content)->with('message', 'Speech Settings has successfully been updated.');
    }

    /**
     * @param Language $language
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function editTranslationSettings(Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        $data['content'] = $content;
        $data['language'] = $language;
        $data['speechSettings'] = SpeechSettingsRepository::find($content, $language);

        return view('admin.translations.speech.settings')->with($data);
    }

    /**
     * @param SpeechSettingsUpdateRequest $request
     * @param Language $language
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateTranslationSettings(SpeechSettingsUpdateRequest $request, Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        SpeechSettingsRepository::createOrUpdate($content, $language, $request->all());

        return redirect()->route('admin.translations.show', [$language, $content])->with('message', 'Speech Settings has successfully been updated.');
    }
}
