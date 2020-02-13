<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    /** @var Role $model */
    private $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
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
