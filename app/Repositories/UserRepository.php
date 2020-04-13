<?php


namespace App\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
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

    public static function create(array $attributes, $password)
    {
        $user = new User();
        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = bcrypt($password);
        $user->save();

        return $user;
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
