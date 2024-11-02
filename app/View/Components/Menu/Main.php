<?php

namespace App\View\Components\Menu;

use App\Models\Community;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Main extends Component
{
    public $user;

    public $userFollowings;

    public function render()
    {
        $communities = Cache::remember('communities', now()->addMinutes(60), function () {
            return Community::withCount('stories')->orderByDesc('stories_count')->take(5)->get();
        });

        if (auth()->user()) {
            $this->userFollowings = getCurrentUser()->followings()->where('followable_type', '=', 'App\Models\User')->take(5)->get();
        }

        return view('components.menu.main', compact('communities'));
    }
}
