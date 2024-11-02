<?php

namespace Database\Seeders;

use App\Models\Story;
use Cviebrock\EloquentTaggable\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name' => 'News', 'normalized' => 'news']);
        Tag::create(['name' => 'Lifestyle', 'normalized' => 'lifestyle']);
        Tag::create(['name' => 'Politics', 'normalized' => 'politics']);
        Tag::create(['name' => 'Entertainment', 'normalized' => 'entertainment']);
        Tag::create(['name' => 'Technology', 'normalized' => 'technology']);
        Tag::create(['name' => 'National', 'normalized' => 'national']);
        Tag::create(['name' => 'Elon Musk', 'normalized' => 'elon-musk']);
        Tag::create(['name' => 'Travel', 'normalized' => 'travel']);
        Tag::create(['name' => 'Space', 'normalized' => 'space']);
        Tag::create(['name' => 'Nova', 'normalized' => 'nova']);
        Tag::create(['name' => 'Jokes', 'normalized' => 'jokes']);
        Tag::create(['name' => 'Finance', 'normalized' => 'finance']);
        Tag::create(['name' => 'Walet', 'normalized' => 'walet']);

        foreach (Story::all() as $story) {
            $story->tags()->attach(Tag::all()->random());
        }
    }
}
