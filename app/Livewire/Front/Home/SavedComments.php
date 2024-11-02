<?php

namespace App\Livewire\Front\Home;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class SavedComments extends Component
{
    use WithPagination;

    public $totalRecords;

    public $loadAmount = 5;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function mount()
    {
        $this->totalRecords = auth()->user()->getFavoriteItems(Comment::class)->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 5;
    }

    public function render()
    {
        $savedComments = auth()->user()->getFavoriteItems(Comment::class)->paginate($this->loadAmount);

        return view('livewire.front.home.saved-comments', compact('savedComments'));
    }
}
