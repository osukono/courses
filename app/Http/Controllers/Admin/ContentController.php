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
use App\Library\Html\Form\Form;
use App\Library\Html\Toolbar\Button;
use App\Library\Html\Toolbar\Dropdown;
use App\Library\Html\Toolbar\DropdownGroup;
use App\Library\Html\Toolbar\DropdownItem;
use App\Library\Html\Toolbar\Group;
use App\Library\Html\Toolbar\Toolbar;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;

class ContentController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::content);
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

        $data['toolbar'] = new Toolbar([
            new Group([
                (new Button())
                    ->accessible(Auth::getUser()->can(Permissions::create_content))
                    ->icon(Button::icon_plus)
                    ->tooltip('Create Content')
                    ->links(route('admin.content.create')),
                (new Button())
                    ->accessible(Auth::getUser()->can(Permissions::restore_content))
                    ->icon($data['trashed'] ? Button::icon_trash_full : Button::icon_trash_empty)
                    ->tooltip('Trash')
                    ->links(route('admin.content.trash'))
            ])
        ]);

        return view('admin.content.index')->with($data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $data['languages'] = LanguageRepository::all()->ordered()->get();
        $data['levels'] = LevelRepository::all()->ordered()->get();
        $data['topics'] = TopicRepository::all()->ordered()->get();

        return view('admin.content.create')->with($data);
    }

    /**
     * @param ContentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(ContentCreateRequest $request)
    {
        $targetContent = ContentRepository::create($request->all());
        $targetContent->repository()->assignEditor(Auth::getUser());

        return redirect()->route('admin.content.show', $targetContent)
            ->with('message', __('admin.messages.created', ['object' => $targetContent]));
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
            ->whereNotIn('id', [$content->language->id])
            ->ordered()->get();
        $data['lessons'] = $content->lessons()
            ->with('disabled')
            ->withCount('exercises')
            ->ordered()->get();

        /*$data['toolbar'] = new Toolbar([
            (new Group([
                (new Button())
                    ->accessible(Auth::getUser()->can(Permissions::update_content))
                    ->icon(Button::icon_plus)
                    ->tooltip('Create Lesson')
                    ->links(route('admin.lessons.create', $content)),
                (new Dropdown([
                    (new DropdownGroup([
                        (new DropdownItem('Content Editors'))
                            ->accessible(Auth::getUser()->can(Permissions::assign_editors))
                            ->links(route('admin.content.editors.index', $content))
                    ])),
                    (new DropdownGroup([
                        (new DropdownItem($content->language))->links(route('admin.content.export', $content)),
                        (new DropdownItem('Content'))
                            ->accessible(Auth::getUser()->hasRole(Roles::admin))
                            ->links(route('admin.content.export.json', $content))
                    ]))->header('Download'),
                    (new DropdownGroup([
                        (new DropdownItem('Content'))
                            ->accessible(Auth::getUser()->hasRole(Roles::admin)),
                        (new Form())
                            ->method('post')
                            ->visible(false)
                    ]))->header('Import')
                ]))->icon(Button::icon_more_vertical),
            ]))
        ]);*/

        return view('admin.content.show')->with($data);
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

        return view('admin.content.edit')->with($data);
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

        return redirect()->route('admin.content.show', $content);
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

        return redirect()->route('admin.content.index')
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

        return redirect()->route('admin.content.index')
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

        return view('admin.content.trash')->with($data);
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

        return view('admin.content.editors')->with($data);
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

        return redirect()->route('admin.content.editors.index', $content)
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

        return redirect()->route('admin.content.editors.index', $content)
            ->with('message', __('admin.messages.editors.removed', ['object' => $user, 'subject' => $content]));
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

        return view('admin.content.log', $data);
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

        try {
            $json = $request->file('json')->store('tmp');

            $job = new ImportContent($content, $json);
            $this->dispatch($job);

            Session::flash('job', $job->getJobStatusId());
        } catch (Exception $e) {
            Log::error($e);
        }

        return redirect()->route('admin.content.show', $content);
    }

    /**
     * @param Content $content
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function moveAudio(Content $content)
    {
        $this->authorize('access', $content);

        try {
            $job = new MoveAudio($content);
            $this->dispatch($job);

            Session::flash('job', $job->getJobStatusId());
        } catch (Exception $e) {
            Log::error($e);
        }

        return redirect()->route('admin.content.show', $content);
    }
}
