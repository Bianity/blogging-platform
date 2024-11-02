<?php

namespace App\Livewire\Front\Poll;

use App\Models\Poll as PollModel;
use App\Models\PollVote;
use Livewire\Component;

class Show extends Component
{
    public $story;

    public $poll;

    public $choices;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->poll = PollModel::where('story_id', $this->story->id)->first();
        $this->choices = $this->poll->choices;
    }

    public function castVote($id)
    {
        PollVote::create([
            'user_id' => auth()->user()->id,
            'poll_id' => $this->poll->id,
            'poll_choice_id' => $id,
        ]);

        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        return view('livewire.front.poll.show');
    }
}
