<?php

namespace App\Livewire\Front\Home;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithPagination;

class Latest extends Component
{
    use WithPagination;

    public $totalRecords;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->totalRecords = Story::published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $storiesLatest = Story::with('user:id,name,username,avatar', 'community:id,name,slug')
            ->select('id', 'title', 'slug', 'summary', 'user_id', 'community_id', 'published_at', 'updated_at')
            ->published()
            ->when($this->totalRecords, function ($query) {
                return $query->latest('published_at');
            })
            ->withCount('comments')
            ->paginate($this->loadAmount);

        return view('livewire.front.home.latest', compact('storiesLatest'));
    }
}
