<?php

namespace Database\Seeders;

use App\Library\Permissions;
use Illuminate\Database\Seeder;
use ReflectionClass;
use ReflectionException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws ReflectionException
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = (new ReflectionClass(Permissions::class))->getConstants();

        foreach ($permissions as $key => $value)
            Permission::create(['name' => $value]);
    }
}
