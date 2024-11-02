<?php

namespace App\Livewire\Front\Home;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithPagination;

class Featured extends Component
{
    use WithPagination;

    public $totalRecords;

    public $selectedPeriod = 1;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->totalRecords = Story::featured()->published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $storiesFeatured = Story::with('user:id,name,username,avatar', 'community:id,name,slug')
            ->featured()
            ->select('id', 'title', 'slug', 'summary', 'user_id', 'community_id', 'published_at', 'updated_at')
            ->when($this->totalRecords, function ($query) {
                return $query->latest('published_at');
            })
            ->withCount('comments')
            ->paginate($this->loadAmount);

        return view('livewire.front.home.featured', compact('storiesFeatured'));
    }
}
