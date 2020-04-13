<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Library\Sidebar;
use App\Mail\Admin\UserCreated;
use App\Repositories\ContentRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::users);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $data['users'] = UserRepository::all()
            ->with([
                'roles' => function (MorphToMany $query) {
                    $query->orderBy('name');
                }
            ])
            ->ordered()->get();

        return view('admin.users.index')->with($data);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * @param UserCreateRequest $request
     * @return RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $password = Str::random(8);
        $user = UserRepository::create($request->all(), $password);

        Mail::to($user)->send(new UserCreated($user, $password));

        return redirect()->route('admin.users.index')
            ->with('message', __('admin.messages.created', ['object' => 'User ' . $user]));
    }

    /**
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        $data['user'] = $user;
        $data['assignedRoles'] = $user->roles()->orderBy('name')->get();

        $data['roles'] = RoleRepository::all()
            ->with([
                'permissions' => function (BelongsToMany $query) {
                    $query->orderBy('name');
                }
            ])
            ->whereNotIn('id', $data['assignedRoles']->pluck('id'))
            ->orderBy('name')->get();

        $data['contents'] = ContentRepository::all()
            ->with(['language', 'level', 'topic'])
            ->hasAccess($user)
            ->ordered()->get();

        $data['translations'] = LanguageRepository::all()
            ->hasAccess($user)
            ->ordered()->get();

        return view('admin.users.show')->with($data);
    }

    /**
     * @param User $user
     * @param Role $role
     * @return RedirectResponse
     */
    public function assignRole(User $user, Role $role)
    {
        $user->repository()->assignRole($role);

        return back()->with('message', $role->name . ' role has successfully been assigned.');
    }

    /**
     * @param User $user
     * @param Role $role
     * @return RedirectResponse
     */
    public function removeRole(User $user, Role $role)
    {
        $user->repository()->removeRole($role);

        return back()->with('message', $role->name . ' role has successfully been removed.');
    }
}
