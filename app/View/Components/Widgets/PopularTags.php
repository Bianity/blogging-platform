<?php

namespace App\View\Components\Widgets;

use App\Models\Story;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class PopularTags extends Component
{
    public function render()
    {
        $popularTags = Cache::remember('popularTags', now()->addMinutes(30), function () {
            return Story::popularTags(10);
        });

        return view('components.widgets.popular-tags', [
            'popularTags' => $popularTags,
        ]);
    }
}
