<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSeoSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('seo.meta_title', 'Bianity demo');
        $this->migrator->add('seo.meta_description', 'Bianity demo meta description');
        $this->migrator->add('seo.og_url', 'https://bianity.me/');
        $this->migrator->add('seo.og_type', 'website');
        $this->migrator->add('seo.og_image', '');
    }
}
