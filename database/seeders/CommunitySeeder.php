<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Community::create(['user_id' => '1', 'name' => 'News', 'slug' => 'news', 'description' => 'The description of news community']);
        Community::create(['user_id' => '1', 'name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'The description of lifestyle community']);
        Community::create(['user_id' => '1', 'name' => 'Fashion', 'slug' => 'fashion', 'description' => 'The description of fashion community']);
        Community::create(['user_id' => '1', 'name' => 'Politics', 'slug' => 'politics', 'description' => 'The description of politics community']);
        Community::create(['user_id' => '1', 'name' => 'World', 'slug' => 'world', 'description' => 'The description of world community']);
        Community::create(['user_id' => '1', 'name' => 'Sports', 'slug' => 'sports', 'description' => 'The description of sports community']);
        Community::create(['user_id' => '1', 'name' => 'Business', 'slug' => 'business', 'description' => 'The description of business community']);
        Community::create(['user_id' => '1', 'name' => 'Gadgets', 'slug' => 'gadgets', 'description' => 'The description of gadgets community']);
        Community::create(['user_id' => '1', 'name' => 'Showbiz', 'slug' => 'showbiz', 'description' => 'The description of showbiz community']);
        Community::create(['user_id' => '1', 'name' => 'Crypto', 'slug' => 'crypto', 'description' => 'The description of crypto community']);
    }
}
