<?php

namespace App\Livewire\Front;

use App\Models\ReportedComment;
use Livewire\Component;
use WireUi\Traits\Actions;

class ReportComment extends Component
{
    use Actions;

    public $comment;

    public $reason;

    public $message;

    public $reportModal;

    protected $rules = [
        'reason' => 'required',
        'message' => 'nullable|max:500',
    ];

    public function report()
    {
        if (! auth()->check()) {
            // Error
            $this->notification([
                'title'       => __('Error'),
                'description' => __('Please login or register to report this comment'),
                'icon'        => 'error',
            ]);

            return;
        }

        if (auth()->id() == $this->comment->user->id) {
            // Error
            $this->notification([
                'title'       => __('You cannot report your own comments'),
                'icon'        => 'error',
            ]);

            return;
        }

        $already_reported = ReportedComment::where('user_id', '=', auth()->id())
            ->where('comment_id', '=', $this->comment->id)
            ->where('is_viewed', '=', false)
            ->first();

        // Let's check that
        if ($already_reported) {
            $this->reportModal = false;

            // Error
            $this->notification([
                'title'       => __('You already reported this comment'),
                'icon'        => 'warning',
            ]);

            return;
        }

        $this->validate();

        ReportedComment::create([
            'story_id' => $this->comment->story->id,
            'comment_id' => $this->comment->id,
            'user_id' => auth()->id(),
            'reason' => $this->reason,
            'message' => $this->message,
        ]);

        $this->notification()->success(
            $title = __('Thank you for reporting!'),
            $description = __('You have chosen the reason ').$this->reason,
        );

        $this->reason = '';

        $this->message = '';

        $this->reportModal = false;
    }

    public function render()
    {
        return view('livewire.front.report-comment');
    }
}
