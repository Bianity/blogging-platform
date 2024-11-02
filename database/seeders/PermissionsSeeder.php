<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        Permission::query()->create([
            'name' => 'access_admin_dashboard',
            'group_name' => 'system',
            'display_name' => __('Access Admin Dashboard'),
            'description' => __('This permission allow user to access to the admin dashboard.'),
            'can_be_removed' => false,
        ]);

        Permission::query()->create([
            'name' => 'access_settings',
            'group_name' => 'system',
            'display_name' => __('Access Settings'),
            'description' => __('This permission allow user to view the settings page.'),
            'can_be_removed' => false,
        ]);

        Permission::query()->create([
            'name' => 'access_contact_form_messages',
            'group_name' => 'system',
            'display_name' => __('Access Contact Form Messages'),
            'description' => __('This permission allow user to view the messages page.'),
            'can_be_removed' => false,
        ]);

        Permission::query()->create([
            'name' => 'add_featured_story',
            'group_name' => 'system',
            'display_name' => __('Mark story to featured'),
            'description' => __('This permission allow user to add story to featured collection.'),
            'can_be_removed' => false,
        ]);

        Permission::generateGroup('communities');
        Permission::generateGroup('stories');
        Permission::generateGroup('comments');
        Permission::generateGroup('tags');
        Permission::generateGroup('pages');
        Permission::generateGroup('reports');
        Permission::generateGroup('users');

        $administrator = Role::query()->where('name', 'administrator')->firstOrFail();
        $permissions = Permission::all();
        $administrator->permissions()->sync($permissions->pluck('id')->all());

        $roleModerator = Role::findByName('moderator');
        $roleModerator->givePermissionTo('view_stories', 'read_stories', 'add_stories', 'edit_stories', 'delete_stories', 'view_comments', 'read_comments', 'add_comments', 'edit_comments', 'delete_comments', 'add_communities');

        $roleEditor = Role::findByName('editor');
        $roleEditor->givePermissionTo('view_stories', 'read_stories', 'add_stories', 'edit_stories', 'delete_stories', 'view_comments', 'read_comments', 'add_comments', 'edit_comments', 'delete_comments', 'add_communities', 'add_featured_story');

        $roleAuthor = Role::findByName('author');
        $roleAuthor->givePermissionTo('view_stories', 'read_stories', 'add_stories', 'edit_stories', 'delete_stories', 'view_comments', 'read_comments', 'add_comments', 'edit_comments', 'delete_comments', 'add_communities');

        $roleAuthor = Role::findByName('user');
        $roleAuthor->givePermissionTo('view_stories', 'read_stories', 'view_comments', 'read_comments', 'add_comments', 'edit_comments', 'delete_comments');

        $roleAuthor = Role::findByName('readonly');
        $roleAuthor->givePermissionTo('view_stories', 'read_stories', 'view_comments', 'read_comments');
    }
}
