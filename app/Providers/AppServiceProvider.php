<?php

namespace App\Providers;

use App\Bindings\CustomWireUiBladeDirectives;
use App\Settings\AdvancedSettings;
use App\Settings\GeneralSettings;
use App\Settings\SeoSettings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use WireUi\WireUiBladeDirectives;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->bind(WireUiBladeDirectives::class, CustomWireUiBladeDirectives::class);

        Validator::extend('alpha_space_numeric', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9A-Za-z\s\-]+$/', $value);
        });

        try {
            View::share('generalSettings', new GeneralSettings());
            View::share('advancedSettings', new AdvancedSettings());
            View::share('seoSettings', new SeoSettings());
        } catch (\PDOException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        try {
            $site_language = app(GeneralSettings::class)->site_language ?? 'en';
        } catch (\PDOException $e) {
            $site_language = 'en';
        }

        // Set locale for application
        app()->setLocale($site_language);
        setlocale(LC_TIME, $site_language.'_'.mb_strtoupper($site_language));
    }
}
