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

use LaravelLang\Locales\Enums\Config;
use LaravelLang\Locales\Enums\Locale as LocaleCode;

trait Aliases
{
    protected function fromAlias(LocaleCode|string|null $locale): ?string
    {
        if ($locale = $locale?->value ?? $locale) {
            return collect($this->aliases())->flip()->get($locale, $locale);
        }

        return $this->stringify($locale);
    }

    protected function toAlias(LocaleCode|string|null $locale): ?string
    {
        if ($locale = $locale?->value ?? $locale) {
            return collect($this->aliases())->get($locale, $locale);
        }

        return $this->stringify($locale);
    }

    protected function aliases(): array
    {
        return config(Config::PublicKey() . '.aliases', []);
    }

    protected function stringify(LocaleCode|string|null $locale): ?string
    {
        if (! is_null($locale)) {
            return $locale->value ?? $locale;
        }

        return null;
    }
}
