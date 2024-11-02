<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class CacheManager extends Page
{
    protected static ?int $navigationSort = 16;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static string $view = 'filament.pages.cache-manager';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Cache Manager');
    }

    public static function getNavigationLabel(): string
    {
        return __('Cache');
    }
}
