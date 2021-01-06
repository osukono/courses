<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\LessonCreateRequest;
use App\Http\Requests\Admin\Content\LessonMoveRequest;
use App\Http\Requests\Admin\Content\LessonRestoreRequest;
use App\Http\Requests\Admin\Content\LessonUpdateRequest;
use App\Lesson;
use App\Library\Sidebar;
use App\Repositories\LanguageRepository;
use App\Repositories\LessonRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
        View::share('current', Sidebar::content);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Lesson $lesson): Factory|View
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

        return view('admin.content.lessons.show')->with($data);
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create(Content $content): Factory|View
    {
        $this->authorize('access', $content);

        $data['content'] = $content;

        return view('admin.content.lessons.create')->with($data);
    }

    /**
     * @param LessonCreateRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(LessonCreateRequest $request, Content $content): RedirectResponse
    {
        $this->authorize('access', $content);

        $lesson = LessonRepository::create($content, $request->all());

        return redirect()->route('admin.lessons.show', $lesson);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Lesson $lesson): Factory|View
    {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;

        return view('admin.content.lessons.edit')->with($data);
    }

    /**
     * @param LessonUpdateRequest $request
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson): RedirectResponse
    {
        $this->authorize('access', $lesson->content);

        $lesson->repository()->update($request->all());

        return redirect()->route('admin.lessons.show', $lesson);
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
    public function destroy(Lesson $lesson): RedirectResponse
    {
        $this->authorize('access', $lesson->content);

        try {
            $lesson->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.content.show', $lesson->content)
            ->with('message', __('admin.messages.trashed.success', ['object' => $lesson]));
    }

    /**
     * @param LessonRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(LessonRestoreRequest $request): RedirectResponse
    {
        $lesson = Lesson::withTrashed()->find($request['id']);

        $this->authorize('access', $lesson->content);

        try {
            $lesson->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.content.show', $lesson->content)
            ->with('message', __('admin.messages.restored.success', ['object' => $lesson]));
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disable(Lesson $lesson): RedirectResponse
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
    public function enable(Lesson $lesson): RedirectResponse
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
    public function trash(Content $content): Factory|View
    {
        $this->authorize('access', $content);

        $data['lessons'] = LessonRepository::trashed()
            ->where('content_id', $content->id)
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);
        $data['content'] = $content;

        return view('admin.content.lessons.trash')->with($data);
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function log(Lesson $lesson): Factory|View
    {
        $this->authorize('access', $lesson->content);

        $data['lesson'] = $lesson;
        $data['ledgers'] = $lesson->ledgers()->with('user')->latest()->paginate(20);

        return view('admin.target.lessons.log', $data);
    }
}
