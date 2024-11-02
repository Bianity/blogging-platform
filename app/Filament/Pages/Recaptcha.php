<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Recaptcha extends Page
{
    protected static ?int $navigationSort = 11;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static string $view = 'filament.pages.recaptcha';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }
}
