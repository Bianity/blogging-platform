<?php

namespace App\Livewire\Front\Story;

use Livewire\Component;

class Show extends Component
{
    public $story;

    public function render()
    {
        return view('livewire.front.story.show');
    }
}
