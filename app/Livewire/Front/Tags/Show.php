<?php

namespace App\Livewire\Front\Tags;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $tag;

    public $totalRecords;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->totalRecords = Story::published()->withAllTags($this->tag)->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function render()
    {
        $tagHasStories = Story::published()->latest()->withAllTags($this->tag)->paginate($this->loadAmount);

        return view('livewire.front.tags.show', [
            'tagHasStories' => $tagHasStories,
        ]);
    }
}
