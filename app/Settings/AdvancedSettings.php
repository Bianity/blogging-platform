<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AdvancedSettings extends Settings
{
    public bool $recaptcha_active;

    public bool $facebook_login_active;

    public bool $google_login_active;

    public bool $adsense_active;

    public string $google_analytics_code;

    public string $custom_head_code;

    public string $custom_footer_code;

    public string $current_file_storage;

    public string $current_mail_driver;

    public string $adsense_client_id;

    public string $banner_above_header;

    public string $banner_before_content;

    public string $banner_after_content;

    public string $banner_sidebar_widget;

    public static function group(): string
    {
        return 'advanced';
    }
}
