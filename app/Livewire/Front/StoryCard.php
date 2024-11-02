<?php

namespace App\Livewire\Front;

use App\Models\Story;
use Livewire\Component;

class StoryCard extends Component
{
    public $story;

    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function render()
    {
        return view('livewire.front.story-card');
    }
}
