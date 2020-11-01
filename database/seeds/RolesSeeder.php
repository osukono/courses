<?php

namespace Database\Seeders;

use App\Library\Permissions;
use App\Library\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => Roles::admin]);

        /** @var Role $contentManager */
        $contentManager = Role::create(['name' => Roles::content_manager]);
        $contentManager->givePermissionTo([
            Permissions::view_admin_panel,

            Permissions::view_content,
            Permissions::create_content,
            Permissions::update_content,
            Permissions::delete_content,
            Permissions::restore_content,

            Permissions::view_translations,
            Permissions::create_translations,
            Permissions::update_translations,
            Permissions::delete_translations,
            Permissions::restore_translations,

            Permissions::assign_editors,
        ]);

        /** @var Role $editor */
        $editor = Role::create(['name' => Roles::editor]);
        $editor->givePermissionTo([
            Permissions::view_admin_panel,

            Permissions::view_content,
            Permissions::update_content,

            Permissions::view_translations,
            Permissions::update_translations
        ]);

        /** @var Role $translator */
        $translator = Role::create(['name' => Roles::translator]);
        $translator->givePermissionTo([
            Permissions::view_admin_panel,

            Permissions::view_content,

            Permissions::view_translations,
            Permissions::update_translations
        ]);

        /** @var Role $recorder */
        $recorder = Role::create(['name' => Roles::recorder]);
        $recorder->givePermissionTo([
            Permissions::view_admin_panel,

            Permissions::view_content,

            Permissions::view_translations
        ]);
    }
}
