<?php

namespace App\Livewire\Front\Comments;

use App\Models\Comment;
use App\Models\Story;
use App\Notifications\CommentAdded;
use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Comments extends Component
{
    use WithPagination;
    use Actions;

    public $story;

    public $perPage = 5;

    public function mount(Story $story)
    {
        $this->story = $story;
        $this->commentsCollection = Comment::take($this->perPage)->get();
    }

    public function loadMore()
    {
        $this->perPage += $this->perPage;
    }

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public $newCommentState = [
        'comment' => '',
    ];

    protected $validationAttributes = [
        'newCommentState.comment' => 'comment',
    ];

    public function addComment()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate([
            'newCommentState.comment' => 'required|string|min:2',
        ]);

        $comment = $this->story->comments()->make($this->newCommentState);
        $comment->user()->associate(auth()->user());
        $comment->save();

        if ($this->story->user != getCurrentUser()) {
            $this->story->user->notify(new CommentAdded($this->story, $comment));
        }

        $this->notification()->success(
            $title = __('Comment was added!'),
        );

        $this->newCommentState = [
            'comment' => '',
        ];

        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        $comments = $this->story
            ->comments()
            ->with(['user', 'replies.user', 'replies.replies', 'replies.replies.user', 'replies.replies.replies.user'])
            ->withCount('replies')
            ->parent()
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.front.comments.comments', [
            'comments' => $comments,
        ]);
    }
}
