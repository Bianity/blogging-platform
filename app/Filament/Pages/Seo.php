<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Seo extends Page
{
    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string $view = 'filament.pages.seo';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Seo');
    }

    public static function getNavigationLabel(): string
    {
        return __('SEO');
    }
}
