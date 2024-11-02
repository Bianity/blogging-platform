<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class PWA extends Page
{
    protected static ?int $navigationSort = 10;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static string $view = 'filament.pages.p-w-a';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('PWA');
    }

    public static function getNavigationLabel(): string
    {
        return __('PWA');
    }
}
