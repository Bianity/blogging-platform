<?php

namespace App\Livewire\Front\Home;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithPagination;

class SavedStories extends Component
{
    use WithPagination;

    public $totalRecords;

    public $loadAmount = 5;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->totalRecords = auth()->user()->getFavoriteItems(Story::class)->published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 5;
    }

    public function render()
    {
        $user = auth()->user();
        $savedStories = $user->getFavoriteItems(Story::class)
            ->when($this->totalRecords, function ($query) {
                return $query->latest('published_at');
            })
            ->withCount('comments')
            ->paginate($this->loadAmount);

        return view('livewire.front.home.saved-stories', compact('savedStories'));
    }
}
