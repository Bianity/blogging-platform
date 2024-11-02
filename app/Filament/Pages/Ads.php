<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Ads extends Page
{
    protected static ?int $navigationSort = 14;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static string $view = 'filament.pages.ads';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Ads');
    }

    public static function getNavigationLabel(): string
    {
        return __('Ads');
    }
}
