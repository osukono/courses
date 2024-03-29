<?php

namespace App\Http\Controllers\Admin;

use App\Exercise;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ExerciseMoveRequest;
use App\Http\Requests\Admin\Content\ExerciseRestoreRequest;
use App\Lesson;
use App\Library\Permissions;
use App\Library\Sidebar;
use App\Repositories\ExerciseDataRepository;
use App\Repositories\ExerciseRepository;
use App\Repositories\LanguageRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ExerciseController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::courses);
    }

    /**
     * @param Request $request
     * @param Exercise $exercise
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Request $request, Exercise $exercise)
    {
        $exercise->load([
            'lesson',
            'lesson.content',
            'lesson.content.language',
            'disabled'
        ]);

        $this->authorize('access', $exercise->lesson->content);

        if (Auth::getUser()->can(Permissions::update_content) && $request->has('data'))
            $data['editData'] = ExerciseDataRepository::find($request->get('data'))->model();

        $data['content'] = $exercise->lesson->content;
        $data['exercise'] = $exercise;
        $data['previous'] = $exercise->repository()->previous();
        $data['next'] = $exercise->repository()->next();
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$exercise->lesson->content->language->id])->ordered()->get();
        $data['exerciseData'] = $exercise->exerciseData()->ordered()->get();

        return view('admin.development.exercises.show')->with($data);
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        $exercise = ExerciseRepository::create($lesson);
        $exerciseData = ExerciseDataRepository::create($exercise);

        return redirect()->route('admin.dev.exercises.show', [$exercise, 'data' => $exerciseData->id]);
    }

    /**
     * @param ExerciseMoveRequest $request
     * @throws AuthorizationException
     */
    public function move(ExerciseMoveRequest $request)
    {
        $exercise = ExerciseRepository::find($request->get('id'))->model();

        $this->authorize('access', $exercise->lesson->content);

        $exercise->repository()->move($request->get('index'));
    }

    /**
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        try {
            $exercise->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.lessons.show', $exercise->lesson)
            ->with('message', __('admin.messages.trashed.success', ['object' => $exercise]));
    }

    /**
     * @param ExerciseRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ExerciseRestoreRequest $request)
    {
        $exercise = Exercise::withTrashed()->find($request['id']);

        $this->authorize('access', $exercise->lesson->content);

        try {
            $exercise->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.lessons.show', $exercise->lesson)
            ->with('message', __('admin.messages.restored.success', ['object' => $exercise]));
    }

    /**
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disable(Exercise $exercise)
    {
        $exercise->load([
            'lesson',
            'lesson.content',
            'lesson.content.language'
        ]);

        $this->authorize('access', $exercise->lesson->content);

        $exercise->repository()->disable($exercise->lesson->content->language);

        return back()->with('message', __('admin.messages.disabled', ['object' => $exercise]));
    }

    /**
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function enable(Exercise $exercise)
    {
        $exercise->load([
            'lesson',
            'lesson.content',
            'lesson.content.language'
        ]);

        $this->authorize('access', $exercise->lesson->content);

        $exercise->repository()->enable($exercise->lesson->content->language);

        return back()->with('message', __('admin.messages.enabled', ['object' => $exercise]));
    }

    /**
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function trash(Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);

        $data['exercises'] = ExerciseRepository::trashed()
            ->where('lesson_id', $lesson->id)
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);
        $data['lesson'] = $lesson;

        return view('admin.development.exercises.trash')->with($data);
    }

    /**
     * @param Exercise $exercise
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function log(Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        $data['exercise'] = $exercise;
        $data['ledgers'] = $exercise->ledgers()->with('user')->latest()->paginate(20);

        return view('admin.development.exercises.log', $data);
    }
}
