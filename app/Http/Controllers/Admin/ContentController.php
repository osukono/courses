<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AssignEditorRequest;
use App\Http\Requests\Admin\Content\ContentCreateRequest;
use App\Http\Requests\Admin\Content\ContentRestoreRequest;
use App\Http\Requests\Admin\Content\ContentUpdateRequest;
use App\Http\Requests\Admin\Content\RemoveEditorRequest;
use App\Jobs\ImportContent;
use App\Library\Permissions;
use App\Library\Sidebar;
use App\Repositories\ContentRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\LevelRepository;
use App\Repositories\TopicRepository;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;

class ContentController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::courses);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $data['contents'] = ContentRepository::all()
            ->with(['language', 'level', 'topic'])
            ->hasAccess(Auth::user())
            ->ordered()->withCount('lessons')->get();
        $data['trashed'] = ContentRepository::trashed()->count();

        return view('admin.development.index')->with($data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $data['languages'] = LanguageRepository::all()->ordered()->get();
        $data['levels'] = LevelRepository::all()->ordered()->get();
        $data['topics'] = TopicRepository::all()->ordered()->get();

        return view('admin.development.courses.create')->with($data);
    }

    /**
     * @param ContentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(ContentCreateRequest $request)
    {
        $content = ContentRepository::create($request->all());
        $content->repository()->assignEditor(Auth::getUser());

        return redirect()->route('admin.dev.courses.show', $content)
            ->with('message', __('admin.messages.created', ['object' => $content]));
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;
        $data['languages'] = LanguageRepository::all()
            ->hasAccess(Auth::getUser())
            ->whereNotIn('id', [$content->language->id])
            ->ordered()->get();
        $data['lessons'] = $content->lessons()
            ->with('disabled')
            ->withCount('exercises')
            ->ordered()->get();

        return view('admin.development.courses.show')->with($data);
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Content $content)
    {
        $this->authorize('access', $content);

        $data['levels'] = LevelRepository::all()->ordered()->get();
        $data['content'] = $content;

        return view('admin.development.courses.edit')->with($data);
    }

    /**
     * @param ContentUpdateRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ContentUpdateRequest $request, Content $content)
    {
        $this->authorize('access', $content);

        $content->repository()->update($request->all());

        return redirect()->route('admin.dev.courses.show', $content);
    }

    /**
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Content $content)
    {
        $this->authorize('access', $content);

        try {
            $content->repository()->delete();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.courses.index')
            ->with('message', __('admin.messages.trashed.success', ['object' => $content]));
    }

    /**
     * @param ContentRestoreRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ContentRestoreRequest $request)
    {
        $content = Content::withTrashed()->find($request->get('id'));
        $this->authorize('access', $content);

        try {
            $content->repository()->restore();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.dev.courses.index')
            ->with('message', __('admin.messages.restored.success', ['object' => $content]));
    }

    /**
     * @return Factory|View
     */
    public function trash()
    {
        $data['contents'] = ContentRepository::trashed()
            ->hasAccess(Auth::user())
            ->with(['ledgers' => function (MorphMany $query) {
                $query->where('event', 'deleted')->latest();
            }, 'ledgers.user'])->orderBy('deleted_at', 'desc')->paginate(20);

        return view('admin.development.trash')->with($data);
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function editors(Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;
        $data['editors'] = $content->editors()->ordered()->get();
        $data['users'] = User::role(Permission::findByName(Permissions::view_content)->roles()->get())
            ->whereNotIn('id', $data['editors']->pluck('id'))->ordered()->get();

        return view('admin.development.courses.editors')->with($data);
    }

    /**
     * @param AssignEditorRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function assignEditor(AssignEditorRequest $request, Content $content)
    {
        $this->authorize('access', $content);

        $user = User::findOrFail($request->get('user_id'));
        $content->repository()->assignEditor($user);

        return redirect()->back()
            ->with('message', __('admin.messages.editors.assigned', ['subject' => $user, 'object' => $content]));
    }

    /**
     * @param RemoveEditorRequest $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function removeEditor(RemoveEditorRequest $request, Content $content)
    {
        $this->authorize('access', $content);

        $user = User::findOrFail($request->get('user_id'));
        $content->repository()->removeEditor($user);

        return redirect()->back()
            ->with('message', __('admin.messages.editors.removed', ['object' => $content, 'subject' => $user]));
    }

    /**
     * @param Content $content
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function log(Content $content)
    {
        $this->authorize('access', $content);

        $data['content'] = $content;
        $data['ledgers'] = $content->ledgers()->with('user')->latest()->paginate(20);

        return view('admin.development.courses.log', $data);
    }

    /**
     * @param Content $content
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function exportText(Content $content)
    {
        $this->authorize('access', $content);

        return response($content->repository()->toPlainText(), 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $content . '.txt"');
    }

    /**
     * @param Content $content
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function exportJson(Content $content)
    {
        $this->authorize('access', $content);

        $json = json_encode($content->repository()->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return response($json, 200)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $content . '.json"');
    }

    /**
     * @param Request $request
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function importJson(Request $request, Content $content)
    {
        $this->authorize('access', $content);

        $json = $request->file('json')->store('tmp');
        $this->dispatchJob(new ImportContent($content, $json), route('admin.dev.courses.show', $content));

        return redirect()->route('admin.dev.courses.show', $content);
    }
}
