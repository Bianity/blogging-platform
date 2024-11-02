<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ThemeSettings extends Settings
{
    public string $theme_active;

    public static function group(): string
    {
        return 'themes';
    }
}
