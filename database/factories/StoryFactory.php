<?php

namespace Database\Factories;

use App\Models\Story;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    use Sluggable;

    protected $model = Story::class;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $title = $this->faker->sentence(),
            'slug' => SlugService::createSlug(Story::class, 'slug', $title),
            'body_rendered' => $this->faker->paragraphs(10, true),
            'published_at' => now(),
            'approved_at' => now(),
        ];
    }

    public function existing()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => $this->faker->numberBetween(1, 8),
                'community_id' => $this->faker->numberBetween(1, 10),
            ];
        });
    }
}
