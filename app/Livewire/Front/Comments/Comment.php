<?php

namespace App\Livewire\Front\Comments;

use App\Models\Story;
use App\Notifications\ReplyAdded;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use WireUi\Traits\Actions;

class Comment extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $comment;

    public $story;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    protected $validationAttributes = [
        'replyState.comment' => 'reply',
    ];

    public $isReplying = false;

    public $replyState = [
        'comment' => '',
    ];

    public $isEditing = false;

    public $editState = [
        'comment' => '',
    ];

    public function updatedIsEditing($isEditing)
    {
        if (! $isEditing) {
            return;
        }

        $this->editState = [
            'comment' => $this->comment->comment,
        ];
    }

    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function cancelIsEditing()
    {
        $this->isEditing = false;
    }

    public function cancelIsReplying()
    {
        $this->isReplying = false;
    }

    public function editComment()
    {
        $this->validate([
            'editState.comment' => 'required|string|min:2',
        ]);

        $this->authorize('update', $this->comment);

        $this->comment->update($this->editState);

        $this->isEditing = false;

        $this->dispatch('refresh');

        $this->notification()->success(
            $title = __('Comment was updated!'),
        );
    }

    public function deleteComment($id)
    {
        $this->authorize('update', $this->comment);

        // Important! All related models need to be deleted, before deleting a comment
        $this->comment->votes()->where('votable_id', '=', $id)->delete();
        $this->comment->favorites()->where('favoriteable_id', '=', $id)->delete();

        $this->comment->delete();

        $this->dispatch('refresh');

        $this->notification()->success(
            $title = __('Comment was deleted!'),
        );
    }

    public function postReply()
    {
        $this->validate([
            'replyState.comment' => 'required|string|min:2',
        ]);

        $reply = $this->comment->replies()->make($this->replyState);
        $reply->user()->associate(auth()->user());
        $reply->commentable()->associate($this->comment->commentable);
        $reply->save();

        if ($this->comment->user != getCurrentUser()) {
            $this->comment->user->notify(new ReplyAdded($reply));
        }

        $this->replyState = [
            'comment' => '',
        ];

        $this->isReplying = false;

        $this->dispatch('refresh')->self();

        $this->notification()->success(
            $title = __('Comment was added!'),
        );
    }

    public function render()
    {
        return view('livewire.front.comments.comment');
    }
}
