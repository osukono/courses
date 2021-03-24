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
use App\LessonImage;
use App\Library\Permissions;
use App\Library\Sidebar;
use App\Repositories\ExerciseDataRepository;
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

        $data['current'] = Sidebar::content;
        $data['language'] = $language;
        $data['content'] = $content;
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$content->language->id])
            ->whereNotIn('id', [$language->id])
            ->ordered()->get();
        $data['lessons'] = $content->lessons()
            ->with('disabled')
            ->withCount('exercises')->ordered()->get();
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
        $lesson->load([
            'content',
            'content.language',
            'disabled'
        ]);

        $this->authorize('access', $lesson->content);
        $this->authorize('access', $language);

        $data['current'] = Sidebar::content;
        $data['language'] = $language;
        $data['content'] = $lesson->content;
        $data['lesson'] = $lesson;
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$lesson->content->language->id])
            ->whereNotIn('id', [$language->id])
            ->ordered()->get();
        $data['exercises'] = $lesson->exercises()
            ->with([
                'exerciseData' => function (HasMany $query) {
                    $query->orderBy('index');
                },
                'exerciseData.translations' => function (HasMany $query) use ($language) {
                    $query->where('language_id', $language->id);
                },
                'disabled'
            ])
            ->ordered()->get();
        $data['previous'] = $lesson->repository()->previous();
        $data['next'] = $lesson->repository()->next();
        $data['trashed'] = ExerciseRepository::trashed()->where('lesson_id', $lesson->id)->count();
        $data['image'] = LessonImage::where('lesson_id', $lesson->id)
            ->where('language_id', $language->id)
            ->first();

        return view('admin.translations.lessons.show')->with($data);
    }

    /**
     * @param Language $language
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disableLesson(Language $language, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);
        $this->authorize('access', $language);

        $lesson->repository()->disable($language);

        return back()->with('message', __('admin.messages.translations.disabled', ['object' => $lesson]));
    }

    /**
     * @param Language $language
     * @param Lesson $lesson
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function enableLesson(Language $language, Lesson $lesson)
    {
        $this->authorize('access', $lesson->content);
        $this->authorize('access', $language);

        $lesson->repository()->enable($language);

        return back()->with('message', __('admin.messages.translations.enabled', ['object' => $lesson]));
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
        $exercise->load([
            'lesson',
            'lesson.content',
            'lesson.content.language',
            'disabled'
        ]);

        $this->authorize('access', $exercise->lesson->content);
        $this->authorize('access', $language);

        if (Auth::getUser()->can(Permissions::update_translations) && $request->has('data')) {
            $editData = ExerciseDataRepository::find($request->get('data'))->model();

            $data['editData'] = $editData;

            if ($editData->translations()->where('language_id', $language->id)->doesntExist()) {
                TranslationRepository::create($language, $editData);
            }
        }

        $data['current'] = Sidebar::content;
        $data['language'] = $language;
        $data['exercise'] = $exercise;
        $data['content'] = $exercise->lesson->content;
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$exercise->lesson->content->language->id])
            ->whereNotIn('id', [$language->id])
            ->get();
        $data['exerciseData'] = $exercise->exerciseData()
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
     * @param Language $language
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function disableExercise(Language $language, Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);
        $this->authorize('access', $language);

        $exercise->repository()->disable($language);

        return back()->with('message', __('admin.messages.translations.disabled', ['object' => $exercise]));
    }

    /**
     * @param Language $language
     * @param Exercise $exercise
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function enableExercise(Language $language, Exercise $exercise)
    {
        $this->authorize('access', $exercise->lesson->content);
        $this->authorize('access', $language);

        $exercise->repository()->enable($language);

        return back()->with('message', __('admin.messages.translations.enabled', ['object' => $exercise]));
    }

    /**
     * @param TranslationUpdateRequest $request
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(TranslationUpdateRequest $request, Translation $translation)
    {
        $this->authorize('access', $translation->exerciseData->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        $translation->repository()->update($request->all());
        $translation->repository()->updateAudio($request);

        return redirect()->route('admin.translations.exercise.show', [$translation->language, $translation->exerciseData->exercise]);
    }

    /**
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteAudio(Translation $translation)
    {
        $this->authorize('access', $translation->exerciseData->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        $translation->repository()->deleteAudio();

        return redirect()->route('admin.translations.exercise.show', [$translation->language, $translation->exerciseData->exercise, 'data' => $translation->exerciseData->id])
            ->with('message', __('admin.messages.deleted.success', ['object' => 'Audio']));
    }

    /**
     * @param Translation $translation
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function synthesizeAudio(Translation $translation)
    {
        $this->authorize('access', $translation->exerciseData->exercise->lesson->content);
        $this->authorize('access', $translation->language);

        try {
            $translation->repository()->synthesizeAudio();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('message', __('admin.messages.audio.synthesized'));
    }

    /**
     * @param Request $request
     * @param Language $language
     * @param Content $content
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function export(Request $request, Language $language, Content $content)
    {
        $this->authorize('access', $content);
        $this->authorize('access', $language);

        return response($content->repository()->toPlainText($language, $request->has('target')), 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $content . ' - ' . $language . '.txt"');
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

        $data['current'] = Sidebar::content;
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
     * @return RedirectResponse
     */
    public function assignEditor(AssignEditorRequest $request, Language $language)
    {
        $user = User::findOrFail($request->get('user_id'));

        $language->repository()->assignEditor($user);

        return redirect()->back()
            ->with('message', __('admin.messages.editors.assigned', ['subject' => $language, 'object' => $user]));
    }

    /**
     * @param RemoveEditorRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function removeEditor(RemoveEditorRequest $request, Language $language)
    {
        $user = User::findOrFail($request->get('user_id'));

        $language->repository()->removeEditor($user);

        return redirect()->back()
            ->with('message', __('admin.messages.editors.removed', ['object' => $language, 'subject' => $user]));
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

        $this->dispatchJob(new CommitContent($content, $language), route('admin.translations.content.show', [$language, $content]));

        return redirect()->route('admin.translations.content.show', [$language, $content]);
    }
}
