<?php


namespace App\Repositories;


use App\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoleRepository
{
    private Role $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param $id
     * @return Model|Role
     */
    public static function find($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * @return Builder|Role
     */
    public static function all()
    {
        return Role::query();
    }

    /**
     * @return Role
     */
    public function model()
    {
        return $this->model;
    }
}
