<?php

namespace App\Livewire\Front;

use App\Models\ReportedStory;
use Livewire\Component;
use WireUi\Traits\Actions;

class ReportStory extends Component
{
    use Actions;

    public $story;

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
                'description' => __('Please login or register to report this story'),
                'icon'        => 'error',
            ]);

            return;
        }

        if (auth()->id() == $this->story->user->id) {
            // Error
            $this->notification([
                'title'       => __('You cannot report your own stories'),
                'icon'        => 'error',
            ]);

            return;
        }

        $already_reported = ReportedStory::where('user_id', '=', auth()->id())
            ->where('story_id', '=', $this->story->id)
            ->where('is_viewed', '=', false)
            ->first();

        // Let's check that
        if ($already_reported) {
            $this->reportModal = false;

            // Error
            $this->notification([
                'title'       => __('You already reported this story'),
                'icon'        => 'warning',
            ]);

            return;
        }

        $this->validate();

        ReportedStory::create([
            'story_id' => $this->story->id,
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
        return view('livewire.front.report-story');
    }
}
