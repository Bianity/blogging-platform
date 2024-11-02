<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $site_language;

    public string $site_logo;

    public string $site_logo_dark;

    public string $site_favicon;

    public bool $setup_completed;

    public bool $site_maintenance_mode;

    public bool $email_verification_active;

    public static function group(): string
    {
        return 'general';
    }
}
