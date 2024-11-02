<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Mail extends Page
{
    protected static ?int $navigationSort = 11;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $view = 'filament.pages.mail';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Mail');
    }

    public static function getNavigationLabel(): string
    {
        return __('Mail');
    }
}
