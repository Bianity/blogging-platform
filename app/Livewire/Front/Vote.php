<?php

namespace App\Livewire\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Vote extends Component
{
    public Model $model;

    public $voteCount;

    public $isUpVoted = false;

    public $isDownVoted = false;

    public $actualVotes;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->voteCount = $this->model->votes->sum('votes');

        if ($this->voteCount === 0) {
            $this->actualVotes = 0;
        } else {
            $this->actualVotes = ($this->voteCount > 0) ? true : false;
        }

        if (Auth::check()) {
            $user = auth()->user();
            $this->isUpVoted = $this->model->isVotedByUser($user, 1) ? true : false;
            $this->isDownVoted = $this->model->isVotedByUser($user, -1) ? true : false;
        }
    }

    public function upVote()
    {
        $user = auth()->user();

        if ($this->model->hasBeenVotedBy($user, 1)) {
            $user->cancelVote($this->model);
            $this->setVoteCount();
            $this->isUpVoted = false;

            return;
        } else {
            $user->upvote($this->model);
            $this->isUpVoted = true;
            $this->setVoteCount();

            return;
        }

        $this->dispatch('refresh')->self();
    }

    public function downVote()
    {
        $user = auth()->user();

        if ($this->model->hasBeenVotedBy($user, -1)) {
            $user->cancelVote($this->model);
            $this->setVoteCount();
            $this->isDownVoted = false;

            return;
        } else {
            $user->downvote($this->model);
            $this->isDownVoted = true;
            $this->setVoteCount();

            return;
        }

        $this->dispatch('refresh')->self();
    }

    public function setVoteCount()
    {
        $this->model->refresh();
        $this->voteCount = $this->model->totalVotes();

        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        return view('livewire.front.vote');
    }
}
