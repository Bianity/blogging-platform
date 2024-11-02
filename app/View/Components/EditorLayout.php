<?php

namespace App\View\Components;

use App\Settings\GeneralSettings;
use Illuminate\View\Component;

class EditorLayout extends Component
{
    public $title;

    public function __construct(GeneralSettings $settings, $title = null)
    {
        $this->title = $title.' | '.$settings->site_name ?? env('APP_NAME');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.editor', ['title' => $this->title]);
    }
}
