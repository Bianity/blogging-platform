<?php

namespace App\View\Components\Widgets;

use App\Models\Story;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class FeaturedStories extends Component
{
    public function render()
    {
        $featuredStories = Cache::remember('featuredStories', now()->addMinutes(30), function () {
            return Story::featured()
                ->published()
                ->latest('published_at')
                ->take(5)
                ->get(['title', 'slug']);
        });

        return view('components.widgets.featured-stories', compact('featuredStories'));
    }
}
