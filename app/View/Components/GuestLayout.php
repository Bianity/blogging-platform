<?php

namespace App\View\Components;

use App\Settings\GeneralSettings;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public $title;

    public function __construct(GeneralSettings $settings, $title = null)
    {
        $this->title = $title.' | '.$settings->site_name ?? env('APP_NAME');
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.guest', ['title' => $this->title]);
    }
}
