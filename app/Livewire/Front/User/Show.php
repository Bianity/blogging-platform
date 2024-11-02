<?php

namespace App\Livewire\Front\User;

use App\Models\Story;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class Show extends Component
{
    use Actions;

    public $user;

    public $userStoriesCount;

    public $loadAmount = 10;

    protected $listeners = [
        'load-more' => 'loadMore',
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->userStoriesCount = Story::where('user_id', $this->user->id)->published()->count();
    }

    public function loadMore()
    {
        $this->loadAmount += 10;
    }

    public function isBanned($id)
    {
        $user = User::find($id);

        if ($user->banned_at === null) {
            $user->banned_at = now();
            $user->save();
            $this->notification()->success(
                $title = __('User successfully was banned!'),
            );
        } else {
            $user->banned_at = null;
            $user->save();
            $this->notification()->success(
                $title = __('User successfully was unbanned!'),
            );
        }

        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        $pinnedStories = Story::where('user_id', $this->user->id)->pinned()->published()->latest('published_at')->take(5)->get();

        $userStoriesLatest = Story::where('user_id', $this->user->id)
            ->published()
            ->latest()
            ->paginate($this->loadAmount);

        return view('livewire.front.user.show', compact('userStoriesLatest', 'pinnedStories'));
    }
}
