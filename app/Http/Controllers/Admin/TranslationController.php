<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Exercise;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AssignEditorRequest;
use App\Http\Requests\Admin\Content\RemoveEditorRequest;
use App\Http\Requests\Admin\Content\TranslationUpdateRequest;
use App\Jobs\CommitContent;
use App\Language;
use App\Lesson;
use App\Library\Permissions;
use App\Repositories\ExerciseFieldRepository;
use App\Repositories\ExerciseRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\LessonRepository;
use App\Repositories\TranslationRepository;
use App\Translation;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class TranslationController extends Controller
{
    /**
     * @param Language $language
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function showContent(Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        $data['language'] = $language;
        $data['content'] = $content;
        $data['languages'] = LanguageRepository::all()
            ->whereNotIn('id', [$content->language->id])
            ->ordered()->get();
        $data['lessons'] = $content->lessons()->withCount('exercises')->ordered()->get();
        $data['trashed'] = LessonRepository::trashed()->where('content_id', $content->id)->count();

        return view('admin.translations.show')->with($data);
    }

    /**
     * @param Language $language
     * @param Lesson $lesson
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function showLesson(Language $language, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);
        $this->authorize('access', $language);

        $data['language'] = $language;
        $data['lesson'] = $lesson;
        $data['languages'] = LanguageRepository::all()
            ->whereNotIn('id', [$lesson->content->language->id])
            ->ordered()->get();
        $data['exercises'] = $lesson->exercises()
            ->with([
                'exerciseFields' => function (HasMany $query) {
                    $query->orderBy('index');
                },
                'exerciseFields.field',
                'exerciseFields.field.dataType',
                'exerciseFields.translations' => function (HasMany $query) use ($language) {
                    $query->where('language_id', $language->id);
                },
            ])
            ->ordered()->get();
        $data['previous'] = $lesson->repository()->previous();
        $data['next'] = $lesson->repository()->next();
        $data['trashed'] = ExerciseRepository::trashed()->where('lesson_id', $lesson->id)->count();

        return view('admin.translations.lessons.show')->with($data);
    }

    /**
     * @param Request $request
     * @param Language $language
     * @param Exercise $exercise
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function showExercise(Request $request, Language $language, Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);
        $this->authorize('access', $language);

        if (Auth::getUser()->can(Permissions::update_content) && $request->has('field')) {
            $editedField = ExerciseFieldRepository::find($request->get('field'))->model();

            $data['editedField'] = $editedField;

            if ($editedField->translations()->where('language_id', $language->id)->doesntExist()) {
                TranslationRepository::create($language, $editedField);
            }
        }

        $data['language'] = $language;
        $data['exercise'] = $exercise;
        $data['content'] = $exercise->lesson->content;
        $data['languages'] = LanguageRepository::all()
            ->whereNotIn('id', [$exercise->lesson->content->language->id])->get();
        $data['exerciseFields'] = $exercise->exerciseFields()
            ->with([
                'translations' => function (HasMany $query) use ($language) {
                    $query->where('language_id', $language->id);
                }
            ])
            ->ordered()->get();

        $data['previous'] = $exercise->repository()->previous();
        $data['next'] = $exercise->repository()->next();

        return view('admin.translations.exercises.show')->with($data);
    }

    /**
     * @param TranslationUpdateRequest $request
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(TranslationUpdateRequest $request, Translation $translation)
    {
        $this->authorize('access', $translation->exerciseField->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        $translation->repository()->update($request->all());
        $translation->repository()->updateAudio($request);

        return redirect()->route('admin.translations.exercise.show', [$translation->language, $translation->exerciseField->exercise]);
    }

    /**
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteAudio(Translation $translation)
    {
        $this->authorize('access', $translation->exerciseField->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        $translation->repository()->deleteAudio();

        return redirect()->route('admin.translations.exercise.show', [$translation->language, $translation->exerciseField->exercise, 'field' => $translation->exerciseField->id])
            ->with('message', __('admin.messages.deleted.success', ['object' => 'Audio']));
    }

    /**
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function synthesizeAudio(Translation $translation)
    {
        $this->authorize('access', $translation->exerciseField->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        try {
            $translation->repository()->synthesizeAudio();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.translations.exercise.show', [$translation->language, $translation->exerciseField->exercise]);
    }

    /**
     * @param Language $language
     * @param Content $content
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function export(Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        return response($content->repository()->toPlainText($language), 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition' , 'attachment; filename="' . $content . ' - ' . $language . '.txt"');
    }

    /**
     * @param Language $language
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function editors(Language $language, Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;
        $data['language'] = $language;
        $data['editors'] = $language->editors()->ordered()->get();
        $data['users'] = User::role(Permission::findByName(Permissions::view_translations)->roles()->get())
            ->whereNotIn('id', $data['editors']->pluck('id'))->ordered()->get();

        return view('admin.translations.editors')->with($data);
    }

    /**
     * @param AssignEditorRequest $request
     * @param Language $language
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function assignEditor(AssignEditorRequest $request, Language $language, Content $content)
    {
        $this->authorize('access', $content);

        $user = User::findOrFail($request->get('user_id'));

        $content->repository()->assignEditor($user);
        $language->repository()->assignEditor($user);

        return redirect()->route('admin.translations.editors.index', [$language, $content])
            ->with('message', __('admin.messages.editors.assigned', ['subject' => $user, 'object' => $language]));
    }

    /**
     * @param RemoveEditorRequest $request
     * @param Language $language
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function removeEditor(RemoveEditorRequest $request, Language $language, Content $content)
    {
        $this->authorize('access', $content);

        $user = User::findOrFail($request->get('user_id'));

        $language->repository()->removeEditor($user);
        $content->repository()->removeEditor($user);

        return redirect()->route('admin.translations.editors.index', [$language, $content])
            ->with('message', __('admin.messages.editors.removed', ['object' => $user, 'subject' => $language]));
    }

    /**
     * @param Language $language
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function commit(Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        $job = new CommitContent($content, $language);
        $this->dispatch($job);
        try {
            $jobStatusId = $job->getJobStatusId();
            Session::flash('job', $jobStatusId);
        } catch (Exception $e) {
        }

        return redirect()->route('admin.translations.content.show', [$language, $content]);
    }
}
