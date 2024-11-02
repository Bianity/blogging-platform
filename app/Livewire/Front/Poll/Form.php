<?php

namespace App\Livewire\Front\Poll;

use App\Models\Poll;
use Livewire\Component;

class Form extends Component
{
    public $story;

    public $question;

    public $choices = [];

    public $text;

    public $maxChoices = 5;

    public $pollEnds;

    public $pollStyle = 'primary';

    public $addPollModal = false;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function getRules()
    {
        return [
            'question' => ['required'],
            'pollEnds' => ['required'],
            'choices' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (count($value) < 2) {
                        return $fail(__('Add a minimum of two choices.'));
                    }
                    if (count($value) > $this->maxChoices) {
                        return $fail(__('Add maximum ').$this->maxChoices.__(' choices.'));
                    }
                },
            ],
            'choices.*.text' => ['required'],
        ];
    }

    protected function getMessages()
    {
        return [
            'choices.required' => __('At least two choices are required.'),
            'choices.*.text.required' => __('Choice cannot be empty.'),
        ];
    }

    public function addChoice()
    {
        $this->validate(['text' => 'required|min:2|max:70']);
        $this->choices[] = ['text' => $this->text];

        $this->text = '';
    }

    public function removeChoice($index)
    {
        unset($this->choices[$index]);

        $this->choices = array_values($this->choices);
    }

    public function savePoll()
    {
        $this->validate($this->getRules(), $this->getMessages());

        $poll = Poll::create([
            'user_id' => auth()->user()->id,
            'story_id' => $this->story->id,
            'question' => $this->question,
            'poll_style' => $this->pollStyle,
            'poll_ends' => $this->pollEnds,
        ]);
        $poll->choices()->createMany($this->choices);

        $this->addPollModal = false;
        $this->dispatch('refresh');
    }

    public function cancelAddPoll()
    {
        $this->question = '';
        $this->choices = [];
        $this->text = '';
        $this->pollEnds = null;
        $this->pollStyle = 'primary';
        $this->addPollModal = false;

        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.front.poll.form');
    }
}
