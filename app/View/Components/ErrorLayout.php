<?php

namespace App\View\Components;

use App\Settings\GeneralSettings;
use Illuminate\View\Component;

class ErrorLayout extends Component
{
    public string $title;

    public string $errorTitle;

    public string $errorMsg;

    public int $errorCode;

    public bool $homeLink;

    public function __construct(GeneralSettings $settings, $errorTitle, $errorMsg, $errorCode, $homeLink, $title = null)
    {
        $this->title = $title.' | '.$settings->site_name ?? env('APP_NAME');
        $this->errorTitle = $errorTitle;
        $this->errorMsg = $errorMsg;
        $this->errorCode = $errorCode;
        $this->homeLink = $homeLink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.error', [
            'title' => $this->title,
            'errorTitle' => $this->errorTitle,
            'errorMsg' => $this->errorMsg,
            'errorCode' => $this->errorCode,
            'homeLink' => $this->homeLink,
        ]);
    }
}
