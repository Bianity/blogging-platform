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

namespace LaravelLang\Locales\Data;

use LaravelLang\Locales\Concerns\Aliases;
use LaravelLang\Locales\Enums\Locale as LocaleEnum;

class LocaleData
{
    use Aliases;

    public readonly string $code;

    public readonly string $type;

    public readonly string $name;

    public readonly string $native;

    public readonly string $localized;

    public readonly ?string $regional;

    public function __construct(LocaleEnum $locale, array $data, NativeData $native)
    {
        $this->code = $this->toAlias($locale);

        $this->type     = $data['type'] ?? 'Latn';
        $this->name     = $data['name'];
        $this->regional = $data['regional'] ?? null;

        $this->native    = $native->getCurrent($this->code);
        $this->localized = $native->getLocalized($this->code);
    }
}
