<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class AdditionalScripts extends Page
{
    protected static ?int $navigationSort = 15;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static string $view = 'filament.pages.additional-scripts';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Additional scripts');
    }

    public static function getNavigationLabel(): string
    {
        return __('Additional scripts');
    }
}
