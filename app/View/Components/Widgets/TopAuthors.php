<?php

namespace App\View\Components\Widgets;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class TopAuthors extends Component
{
    public function render()
    {
        $topAuthors = Cache::remember('topAuthors', now()->addMinutes(30), function () {
            return User::select('name', 'username', 'avatar')->mostStoriesInLastDays(365)->take(5)->get();
        });

        return view('components.widgets.top-authors', [
            'topAuthors' => $topAuthors,
        ]);
    }
}
