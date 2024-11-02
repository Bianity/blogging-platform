<?php

namespace App\Livewire\Front\Home;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithPagination;

class MyFeed extends Component
{
    use WithPagination;

    public $totalRecords;

    public $followingsId;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->followingsId = auth()->user()->followings()->pluck('followable_id');
        $this->totalRecords = Story::whereIn('user_id', $this->followingsId)->published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $userFeed = Story::with('user:id,name,username,avatar', 'community:id,name,slug')
            ->select('id', 'title', 'slug', 'summary', 'user_id', 'community_id', 'published_at', 'updated_at')
            ->whereIn('user_id', $this->followingsId)
            ->when($this->totalRecords, function ($query) {
                return $query->latest('published_at');
            })
            ->withCount('comments')
            ->paginate($this->loadAmount);

        return view('livewire.front.home.my-feed', compact('userFeed'));
    }
}
