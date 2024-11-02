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

namespace LaravelLang\Locales\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelLang\Locales\Data\LocaleData;
use LaravelLang\Locales\Enums\Locale;
use LaravelLang\Locales\Services\Locales as Service;
use LaravelLang\Locales\Services\RawLocales;

/**
 * @method static array<LocaleData> available()
 * @method static array<LocaleData> installed(bool $withProtects = true)
 * @method static array<LocaleData> notInstalled()
 * @method static array<LocaleData> protects()
 * @method static bool isAvailable(string|Locale|null $locale)
 * @method static bool isInstalled(string|Locale|null $locale)
 * @method static bool isProtected(string|Locale|null $locale)
 * @method static LocaleData get(mixed $locale)
 * @method static LocaleData getDefault()
 * @method static LocaleData getFallback()
 * @method static RawLocales raw()
 */
class Locales extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
