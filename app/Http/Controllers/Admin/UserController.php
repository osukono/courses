<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Sidebar;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        $data['user'] = $user;
        $data['assignedRoles'] = $user->roles()->orderBy('name')->get();
        $data['roles'] = RoleRepository::all()
            ->with([
                'permissions' => function(BelongsToMany $query) {
                    $query->orderBy('name');
                }
            ])
            ->whereNotIn('id', $data['assignedRoles']->pluck('id'))
            ->orderBy('name')->get();

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
