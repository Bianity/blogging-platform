<?php

namespace App\Livewire\Front\Home;

use App\Models\Story;
use CyrildeWit\EloquentViewable\Support\Period;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
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
        $this->totalRecords = Story::published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $storiesPopular = Story::with('user:id,name,username,avatar', 'community:id,name,slug')
            ->select('id', 'title', 'slug', 'summary', 'user_id', 'community_id', 'published_at', 'updated_at')
            ->published()
            ->when($this->selectedPeriod, function ($query) {
                return $query->orderByViews('desc', Period::pastDays($this->selectedPeriod));
            })
            ->withCount('comments')
            ->paginate($this->loadAmount);

        return view('livewire.front.home.index', compact('storiesPopular'));
    }
}
