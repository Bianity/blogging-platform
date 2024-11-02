<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator',
            'description' => 'Site administrator with full access to admin panel.',
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'moderator',
            'display_name' => 'Moderator',
            'description' => 'Site moderator can moderate comments (edit, delete), ban user and choose featured stories.',
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Editor can choose featured stories. The chosen story display on main page.',
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'author',
            'display_name' => 'Author',
            'description' => 'Default role after register. Role with access on front site.',
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Role with access, only chatting in the comments.',
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'readonly',
            'display_name' => 'User read-only',
            'description' => 'The user cannot create entries or comments',
            'can_be_removed' => false,
        ]);
    }
}
