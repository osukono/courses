<?php


namespace App\Repositories;


use App\Course;
use App\User;
use App\UserCourse;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserRepository
{
    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return User|Builder
     */
    public static function all()
    {
        return User::query();
    }

    /**
     * @param Role $role
     */
    public function assignRole(Role $role)
    {
        $this->model->assignRole($role);
    }

    /**
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->model->removeRole($role);
    }

    /**
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }
}
