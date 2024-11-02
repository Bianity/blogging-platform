<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $casts = [
        'can_be_removed' => 'boolean',
    ];

    // Get a lists of permissions groups
    public static function groups(): array
    {
        return [
            'system' => __('System'),
            'communities' => __('Communities'),
            'stories' => __('Stories'),
            'comments' => __('Comments'),
            'tags' => __('Tags'),
            'pages' => __('Pages'),
            'reports' => __('Reports'),
            'users' => __('Users'),
        ];
    }

    // Generate permissions for the group name
    public static function generateGroup(string $item, ?string $group = null): void
    {
        self::query()->firstOrCreate([
            'name' => 'view_'.$item,
            'group_name' => $group ?? $item,
            'display_name' => __('View :item', ['item' => ucfirst($item)]),
            'description' => __('This permission allow you to view all the :item, with actions as search, filters and more.', ['item' => $item]),
            'can_be_removed' => false,
        ]);

        self::query()->firstOrCreate([
            'name' => 'read_'.$item,
            'group_name' => $group ?? $item,
            'display_name' => __('Read :item', ['item' => ucfirst($item)]),
            'description' => __('This permission allow you to read the content of a record of :item.', ['item' => $item]),
            'can_be_removed' => false,
        ]);

        self::query()->firstOrCreate([
            'name' => 'add_'.$item,
            'group_name' => $group ?? $item,
            'display_name' => __('Add :item', ['item' => ucfirst($item)]),
            'description' => __('This permission allow you to add a new record of :item.', ['item' => $item]),
            'can_be_removed' => false,
        ]);

        self::query()->firstOrCreate([
            'name' => 'edit_'.$item,
            'group_name' => $group ?? $item,
            'display_name' => __('Edit :item', ['item' => ucfirst($item)]),
            'description' => __('This permission allow you to edit the content of a record of :item.', ['item' => $item]),
            'can_be_removed' => false,
        ]);

        self::query()->firstOrCreate([
            'name' => 'delete_'.$item,
            'group_name' => $group ?? $item,
            'display_name' => __('Delete :item', ['item' => ucfirst($item)]),
            'description' => __('This permission allow you to removed a record of :item.', ['item' => $item]),
            'can_be_removed' => false,
        ]);
    }
}
