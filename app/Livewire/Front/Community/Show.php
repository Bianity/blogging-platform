<?php

namespace App\Livewire\Front\Community;

use App\Models\Story;
use Livewire\Component;

class Show extends Component
{
    public $community;

    public $communityStoriesCount;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->communityStoriesCount = Story::where('community_id', $this->community->id)->published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $communityStoriesLatest = Story::where('community_id', $this->community->id)
            ->published()
            ->latest('published_at')
            ->with('user')
            ->paginate($this->loadAmount);

        return view('livewire.front.community.show', compact('communityStoriesLatest'));
    }
}
