<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Sitemap extends Page
{
    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static string $view = 'filament.pages.sitemap';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Sitemap');
    }

    public static function getNavigationLabel(): string
    {
        return __('Sitemap');
    }
}
