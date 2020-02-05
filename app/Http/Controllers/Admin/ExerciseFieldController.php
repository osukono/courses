<?php

namespace App\Http\Controllers\Admin;

use App\Exercise;
use App\ExerciseField;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ExerciseFieldCreateRequest;
use App\Http\Requests\Admin\Content\ExerciseFieldMoveRequest;
use App\Http\Requests\Admin\Content\ExerciseFieldRestoreRequest;
use App\Http\Requests\Admin\Content\ExerciseFieldUpdateRequest;
use App\Library\Str;
use App\Library\TextToSpeech;
use App\Repositories\ExerciseFieldRepository;
use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExerciseFieldController extends Controller
{
    /**
     * @param ExerciseFieldCreateRequest $request
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ExerciseFieldCreateRequest $request, Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        $exerciseField = ExerciseFieldRepository::create($exercise, $request->all());

        return redirect()->route('admin.exercises.show', [$exercise, 'field' => $exerciseField->id]);
    }

    /**
     * @param ExerciseFieldUpdateRequest $request
     * @param ExerciseField $exerciseField
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ExerciseFieldUpdateRequest $request, ExerciseField $exerciseField)
    {
        $this->authorize('access', $exerciseField->exercise->lesson->content);

        $exerciseField->repository()->update($request->all());
        $exerciseField->repository()->updateAudio($request);

        return redirect()->route('admin.exercises.show', $exerciseField->exercise);
    }

    /**
     * @param ExerciseField $exerciseField
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteAudio(ExerciseField $exerciseField)
    {
        $this->authorize('access', $exerciseField->exercise->lesson->content);

        $exerciseField->repository()->deleteAudio();

        return redirect()->route('admin.exercises.show', [$exerciseField->exercise, 'field' => $exerciseField->id])
            ->with('message', __('admin.messages.deleted.success', ['object' => 'Audio']));
    }

    /**
     * @param ExerciseField $exerciseField
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(ExerciseField $exerciseField)
    {
        $this->authorize('access', $exerciseField->exercise->lesson->content);

        try {
            $exerciseField->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.exercises.show', $exerciseField->exercise)
            ->with('message', __('admin.messages.trashed.success', ['object' => $exerciseField]));
    }

    /**
     * @param ExerciseFieldRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ExerciseFieldRestoreRequest $request)
    {
        $exerciseField = ExerciseField::withTrashed()->find($request['id']);

        $this->authorize('access', $exerciseField->exercise->lesson->content);

        try {
            $exerciseField->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.exercises.show', $exerciseField->exercise)
            ->with('message', __('admin.messages.restored.success', ['object' => $exerciseField]));
    }

    /**
     * @param Exercise $exercise
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function trash(Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);

        $data['exerciseFields'] = ExerciseFieldRepository::trashed()
            ->where('exercise_id', $exercise->id)
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);
        $data['exercise'] = $exercise;

        return view('admin.content.exercises.fields.trash')->with($data);
    }

    /**
     * @param ExerciseFieldMoveRequest $request
     * @throws AuthorizationException
     */
    public function move(ExerciseFieldMoveRequest $request)
    {
        $exerciseField = ExerciseFieldRepository::find($request->get('id'))->model();

        $this->authorize('access', $exerciseField->exercise->lesson->content);

        $exerciseField->repository()->move($request->get('index'));
    }

    /**
     * @param ExerciseField $exerciseField
     * @return RedirectResponse
     * @throws ApiException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function synthesizeAudio(ExerciseField $exerciseField)
    {
        $this->authorize('access', $exerciseField->exercise->lesson->content);

        $exerciseField->repository()->synthesizeAudio();

        return redirect()->route('admin.exercises.show', $exerciseField->exercise);
    }
}
