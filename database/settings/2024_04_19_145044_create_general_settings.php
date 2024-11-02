<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Bianity');
        $this->migrator->add('general.email_verification_active', false);
        $this->migrator->add('general.site_logo', '');
        $this->migrator->add('general.site_logo_dark', '');
        $this->migrator->add('general.site_favicon', '');
    }
}
