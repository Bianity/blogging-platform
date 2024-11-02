<?php

namespace App\Livewire\Front\Home;

use App\Models\Community;
use Livewire\Component;

class TopCommunities extends Component
{
    public function render()
    {
        $communitiesList = Community::query()
            ->orderByFollowersCountDesc()
            ->take(10)
            ->get();

        return view('livewire.front.home.top-communities', [
            'communitiesList' => $communitiesList,
        ]);
    }
}
