<?php

namespace App\Library;


class Permissions
{
    public const view_admin_panel = 'view admin panel';

    public const view_courses = 'view courses';
    public const update_courses = 'update courses';
    public const publish_courses = 'publish courses';

    public const view_content = 'view content';
    public const create_content = 'create content';
    public const update_content = 'update content';
    public const delete_content = 'delete content';
    public const restore_content = 'restore content';

    public const view_podcasts = 'view podcasts';
    public const create_podcasts = 'create podcasts';
    public const update_podcasts = 'update podcasts';

    public const view_translations = 'view translations';
    public const create_translations = 'create translations'; //redundant
    public const update_translations = 'update translations';
    public const delete_translations = 'delete translations'; //redundant
    public const restore_translations = 'restore translations'; //redundant

    public const view_users = 'view users';
    public const create_users = 'create users';
    public const suspend_users = 'suspend users';
    public const assign_roles = 'assign roles';

    public const assign_editors = 'assign editors';
}
