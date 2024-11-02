<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Storage extends Page
{
    protected static ?int $navigationSort = 13;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static string $view = 'filament.pages.storage';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Storage');
    }

    public static function getNavigationLabel(): string
    {
        return __('Storage');
    }
}
