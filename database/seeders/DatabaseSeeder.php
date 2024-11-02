<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('DEMO_MODE') === false && app()->environment('production')) {
            $this->call([
                RolesSeeder::class,
                PermissionsSeeder::class,
                PageSeeder::class,
            ]);
        }

        if (env('DEMO_MODE') === true && app()->environment('local')) {
            $this->call([
                RolesSeeder::class,
                PermissionsSeeder::class,
                UserSeeder::class,
                CommunitySeeder::class,
                PageSeeder::class,
                StorySeeder::class,
                TagSeeder::class,
            ]);
        }
    }
}
