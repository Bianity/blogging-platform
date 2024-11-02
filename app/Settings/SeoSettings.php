<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public string $meta_title;

    public string $meta_description;

    public string $meta_keywords;

    public string $og_site_name;

    public string $og_title;

    public string $og_description;

    public string $og_url;

    public string $og_type;

    public string $og_image;

    public string $sitemap_update;

    public static function group(): string
    {
        return 'seo';
    }
}
