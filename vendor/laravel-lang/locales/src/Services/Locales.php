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

namespace LaravelLang\Locales\Services;

use LaravelLang\Locales\Concerns\Aliases;
use LaravelLang\Locales\Concerns\Localized;
use LaravelLang\Locales\Concerns\Mapping;
use LaravelLang\Locales\Concerns\Registry;
use LaravelLang\Locales\Data\LocaleData;
use LaravelLang\Locales\Enums\Locale;

class Locales
{
    use Aliases;
    use Localized;
    use Mapping;
    use Registry;

    public function __construct(
        protected RawLocales $raw
    ) {}

    public function raw(): RawLocales
    {
        return $this->raw;
    }

    public function available(): array
    {
        return $this->registry(__METHOD__, fn () => $this->mapLocales($this->raw->available()));
    }

    public function installed(bool $withProtects = true): array
    {
        return $this->registry(
            [__METHOD__, $withProtects],
            fn () => $this->mapLocales($this->raw->installed($withProtects))
        );
    }

    public function notInstalled(): array
    {
        return $this->registry(__METHOD__, fn () => $this->mapLocales($this->raw->notInstalled()));
    }

    public function protects(): array
    {
        return $this->registry(__METHOD__, fn () => $this->mapLocales($this->raw->protects()));
    }

    public function isAvailable(Locale|string|null $locale): bool
    {
        return $this->raw->isAvailable($locale);
    }

    public function isInstalled(Locale|string|null $locale): bool
    {
        return $this->raw->isInstalled($locale);
    }

    public function isProtected(Locale|string|null $locale): bool
    {
        return $this->raw->isProtected($locale);
    }

    public function get(mixed $locale): LocaleData
    {
        return $this->registry([__METHOD__, $locale], fn () => $this->map($this->raw->get($locale)));
    }

    public function getDefault(): LocaleData
    {
        return $this->registry(__METHOD__, fn () => $this->map($this->raw->getDefault()));
    }

    public function getFallback(): LocaleData
    {
        return $this->registry(__METHOD__, fn () => $this->map($this->raw->getFallback()));
    }
}
