<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SetupLayout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title.' | '.__('Alma Installation');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.setup', ['title' => $this->title]);
    }
}
