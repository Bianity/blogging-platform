<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->createQuietly([
            'name' => 'Bianity',
            'username' => 'admin',
            'email' => 'admin@bianity.me',
            'password' => bcrypt('12345678'),
        ])->assignRole('administrator')->profile()->save(Profile::factory()->make());

        User::factory()->createQuietly([
            'name' => 'Lord Moder',
            'username' => 'moder',
            'email' => 'moder@bianity.me',
            'password' => bcrypt('12345678'),
        ])->assignRole('moderator')->profile()->save(Profile::factory()->make());

        User::factory()->createQuietly([
            'name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@bianity.me',
            'password' => bcrypt('12345678'),
        ])->assignRole('editor')->profile()->save(Profile::factory()->make());

        User::factory(5)->create()->each(function ($user) {
            $user->profile()->save(Profile::factory()->make());
            $user->assignRole('author');
        });
    }
}
