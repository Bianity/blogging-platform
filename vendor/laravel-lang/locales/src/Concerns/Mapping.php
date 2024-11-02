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

namespace LaravelLang\Locales\Concerns;

use LaravelLang\Locales\Data\LocaleData;
use LaravelLang\Locales\Enums\Config;
use LaravelLang\Locales\Enums\Locale as LocaleEnum;

trait Mapping
{
    protected function map(string $locale): LocaleData
    {
        $locale = $this->findLocale($locale);

        return new LocaleData($locale, $this->mapData($locale), $this->localized());
    }

    protected function mapLocales(array $locales): array
    {
        return array_map(fn (string $locale) => $this->map($locale), $locales);
    }

    protected function findLocale(string $locale): LocaleEnum
    {
        return LocaleEnum::tryFrom($this->toAlias($locale))
            ?: LocaleEnum::tryFrom($this->fromAlias($locale))
                ?: LocaleEnum::English;
    }

    protected function mapData(LocaleEnum $locale): array
    {
        return config(Config::PrivateKey() . '.map.' . $locale->value);
    }
}
