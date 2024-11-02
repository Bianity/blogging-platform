<?php

/**
 * This file is part of the "laravel-lang/locales" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Locales;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Locales\Concerns\About;
use LaravelLang\Locales\Enums\Config;

class ServiceProvider extends BaseServiceProvider
{
    use About;

    public function boot(): void
    {
        $this->bootPublishes();
    }

    public function register(): void
    {
        $this->registerConfig();
        $this->registerAbout();
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/public.php' => $this->app->configPath(Config::PublicKey() . '.php'),
        ], ['config', Config::PublicKey()]);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/public.php', Config::PublicKey());
        $this->mergeConfigFrom(__DIR__ . '/../config/private.php', Config::PrivateKey());
    }
}
