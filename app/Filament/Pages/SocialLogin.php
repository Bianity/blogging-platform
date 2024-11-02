<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class SocialLogin extends Page
{
    protected static ?int $navigationSort = 12;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static string $view = 'filament.pages.social-login';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Social login');
    }

    public static function getNavigationLabel(): string
    {
        return __('Social login');
    }
}
