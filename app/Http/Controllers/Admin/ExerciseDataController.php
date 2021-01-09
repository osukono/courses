<?php

namespace App\Http\Controllers\Admin;

use App\Exercise;
use App\ExerciseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ExerciseDataMoveRequest;
use App\Http\Requests\Admin\Content\ExerciseDataRestoreRequest;
use App\Language;
use App\Library\Sidebar;
use App\Repositories\ExerciseDataRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\View;

class ExerciseDataController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::content);
    }

    /**
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        $exerciseData = ExerciseDataRepository::create($exercise);

        return redirect()->route('admin.exercises.show', [$exercise, 'data' => $exerciseData->id]);
    }

    /**
     * @param Request $request
     * @param ExerciseData $exerciseData
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, ExerciseData $exerciseData)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);

        $exerciseData->repository()->update($request->all());
        $exerciseData->repository()->updateAudio($request);

        return redirect()->route('admin.exercises.show', $exerciseData->exercise);
    }

    /**
     * @param ExerciseData $exerciseData
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteAudio(ExerciseData $exerciseData)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);

        $exerciseData->repository()->deleteAudio();

        return redirect()->route('admin.exercises.show', [$exerciseData->exercise, 'field' => $exerciseData->id])
            ->with('message', __('admin.messages.deleted.success', ['object' => 'Audio']));
    }

    /**
     * @param ExerciseData $exerciseData
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(ExerciseData $exerciseData)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);

        try {
            $exerciseData->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.exercises.show', $exerciseData->exercise)
            ->with('message', __('admin.messages.trashed.success', ['object' => $exerciseData]));
    }

    /**
     * @param ExerciseDataRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ExerciseDataRestoreRequest $request)
    {
        $exerciseData = ExerciseData::withTrashed()->find($request['id']);

        $this->authorize('access', $exerciseData->exercise->lesson->content);

        try {
            $exerciseData->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.exercises.show', $exerciseData->exercise)
            ->with('message', __('admin.messages.restored.success', ['object' => $exerciseData]));
    }

    /**
     * @param ExerciseData $exerciseData
     * @param Language $language
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disable(ExerciseData $exerciseData, Language $language)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);
        $this->authorize('access', $language);

        $exerciseData->repository()->disable($language);

        return back()->with('message', __('admin.messages.disabled', ['object' => $exerciseData]));
    }

    /**
     * @param ExerciseData $exerciseData
     * @param Language $language
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function enable(ExerciseData $exerciseData, Language $language)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);
        $this->authorize('access', $language);

        $exerciseData->repository()->enable($language);

        return back()->with('message', __('admin.messages.enabled', ['object' => $exerciseData]));
    }

    /**
     * @param Exercise $exercise
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function trash(Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        $data['exerciseData'] = ExerciseDataRepository::trashed()
            ->where('exercise_id', $exercise->id)
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);
        $data['exercise'] = $exercise;

        return view('admin.content.exercises.data.trash')->with($data);
    }

    /**
     * @param ExerciseDataMoveRequest $request
     * @throws AuthorizationException
     */
    public function move(ExerciseDataMoveRequest $request)
    {
        $exerciseData = ExerciseDataRepository::find($request->get('id'))->model();

        $this->authorize('access', $exerciseData->exercise->lesson->content);

        $exerciseData->repository()->move($request->get('index'));
    }

    /**
     * @param ExerciseData $exerciseData
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function synthesizeAudio(ExerciseData $exerciseData)
    {
        $this->authorize('access', $exerciseData->exercise->lesson->content);

        try {
            $exerciseData->repository()->synthesizeAudio();
        } catch (Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

        return back()->with('The audio has successfully been synthesized?');
    }
}
