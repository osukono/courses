<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\LessonCreateRequest;
use App\Http\Requests\Admin\Content\LessonMoveRequest;
use App\Http\Requests\Admin\Content\LessonRestoreRequest;
use App\Http\Requests\Admin\Content\LessonUpdateDescriptionRequest;
use App\Http\Requests\Admin\Content\LessonUpdateGrammarPointRequest;
use App\Http\Requests\Admin\Content\LessonUpdateRequest;
use App\Http\Requests\Admin\Content\LessonUploadImageRequest;
use App\Language;
use App\Lesson;
use App\Library\Sidebar;
use App\Repositories\LanguageRepository;
use App\Repositories\LessonAssetRepository;
use App\Repositories\LessonRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LessonController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::development);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Lesson $lesson)
    {
        $lesson->load([
            'content',
            'content.language',
            'disabled'
        ]);

        $this->authorize('access', $lesson->content);

        $data['content'] = $lesson->content;
        $data['lesson'] = $lesson;
        $data['previous'] = $lesson->repository()->previous();
        $data['next'] = $lesson->repository()->next();
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$lesson->content->language->id])
            ->ordered()->get();
        $data['exercises'] = $lesson->exercises()
            ->with([
                'exerciseData' => function (HasMany $query) {
                    $query->orderBy('index');
                },
                'disabled'
            ])
            ->ordered()->get();
        $data['image'] = LessonAssetRepository::getImage($lesson, $lesson->content->language);
        $data['grammar_point'] = LessonAssetRepository::getGrammarPoint($lesson, $lesson->content->language);
        $data['description'] = LessonAssetRepository::getDescription($lesson, $lesson->content->language);

        return view('admin.development.lessons.show')->with($data);
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create(Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;

        return view('admin.development.lessons.create')->with($data);
    }

    /**
     * @param LessonCreateRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(LessonCreateRequest $request, Content $content)
    {
        $this->authorize('access', $content);

        $lesson = LessonRepository::create($content, $request->all());

        return redirect()->route('admin.dev.lessons.show', $lesson);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;

        return view('admin.development.lessons.edit')->with($data);
    }

    /**
     * @param LessonUpdateRequest $request
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        $lesson->repository()->update($request->all());

        return redirect()->route('admin.dev.lessons.show', $lesson);
    }

    /**
     * @param LessonUploadImageRequest $request
     * @param Lesson $lesson
     * @param Language $language
     * @return RedirectResponse
     * @throws FileNotFoundException|AuthorizationException
     */
    public function uploadImage(LessonUploadImageRequest $request, Lesson $lesson, Language $language)
    {
        $this->authorize('access', $lesson->content);
        $this->authorize('access', $language);

        LessonAssetRepository::uploadImage($lesson, $language, $request);

        return back();
    }

    /**
     * @param Lesson $lesson
     * @return Application|Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function editGrammarPoint(Lesson $lesson) {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;
        $data['grammar_point'] = LessonAssetRepository::getGrammarPoint($lesson, $lesson->content->language);

        return view('admin.development.lessons.grammar')->with($data);
    }

    /**
     * @param LessonUpdateGrammarPointRequest $request
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateGrammarPoint(LessonUpdateGrammarPointRequest $request, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        LessonAssetRepository::updateGrammarPoint($lesson, $lesson->content->language, $request);

        return redirect()->route('admin.dev.lessons.show', $lesson)
            ->with('message', 'Grammar point has successfully been updated.');
    }

    /**
     * @param Lesson $lesson
     * @return Application|Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function editDescription(Lesson $lesson) {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;
        $data['description'] = LessonAssetRepository::getDescription($lesson, $lesson->content->language);

        return view('admin.development.lessons.description')->with($data);
    }

    /**
     * @param LessonUpdateDescriptionRequest $request
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateDescription(LessonUpdateDescriptionRequest $request, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        LessonAssetRepository::updateDescription($lesson, $lesson->content->language, $request);

        return redirect()->route('admin.dev.lessons.show', $lesson)
            ->with('message', 'Description has successfully been updated.');
    }

    /**
     * @param Lesson $lesson
     * @param Language $language
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteImage(Lesson $lesson, Language $language)
    {
        $this->authorize('access', $lesson->content);

        LessonAssetRepository::deleteImage($lesson, $language);

        return back();
    }

    /**
     * @param LessonMoveRequest $request
     * @throws AuthorizationException
     */
    public function move(LessonMoveRequest $request)
    {
        $lesson = LessonRepository::find($request->get('id'))->model();

        $this->authorize('access', $lesson->content);

        $lesson->repository()->move($request->get('index'));
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        try {
            $lesson->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.courses.show', $lesson->content)
            ->with('message', __('admin.messages.trashed.success', ['object' => $lesson]));
    }

    /**
     * @param LessonRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(LessonRestoreRequest $request)
    {
        $lesson = Lesson::withTrashed()->find($request['id']);

        $this->authorize('access', $lesson->content);

        try {
            $lesson->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.courses.show', $lesson->content)
            ->with('message', __('admin.messages.restored.success', ['object' => $lesson]));
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disable(Lesson $lesson)
    {
        $lesson->load([
            'content',
            'content.language'
        ]);

        $this->authorize('access', $lesson->content);

        $lesson->repository()->disable($lesson->content->language);

        return back()->with('message', __('admin.messages.disabled', ['object' => $lesson]));
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function enable(Lesson $lesson)
    {
        $lesson->load([
            'content',
            'content.language'
        ]);

        $this->authorize('access', $lesson->content);

        $lesson->repository()->enable($lesson->content->language);

        return back()->with('message', __('admin.messages.enabled', ['object' => $lesson]));
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function trash(Content $content)
    {
        $this->authorize('access', $content);

        $data['lessons'] = LessonRepository::trashed()
            ->where('content_id', $content->id)
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);
        $data['content'] = $content;

        return view('admin.development.lessons.trash')->with($data);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function log(Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;
        $data['ledgers'] = $lesson->ledgers()->with('user')->latest()->paginate(20);

        return view('admin.development.lessons.log', $data);
    }
}
