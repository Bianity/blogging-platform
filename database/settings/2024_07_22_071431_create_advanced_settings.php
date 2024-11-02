<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAdvancedSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('advanced.recaptcha_active', false);
        $this->migrator->add('advanced.facebook_login_active', false);
        $this->migrator->add('advanced.google_login_active', false);
        $this->migrator->add('advanced.banner_after_content', '');
        $this->migrator->add('advanced.banner_sidebar_widget', '');
    }
}
