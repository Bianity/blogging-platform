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

namespace LaravelLang\Locales\Enums;

use ArchTech\Enums\Values;
use Illuminate\Support\Collection;

/**
 * Based on ISO 15897.
 *
 * @see https://laravel.com/docs/localization#introduction
 *
 * Unicode standard (Intl)
 * @see https://icu4c-demos.unicode.org/icu-bin/locexp
 *
 * ISO-639-1 standard
 * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */
enum Locale: string
{
    use Values;

    case Afrikaans          = 'af';
    case Albanian           = 'sq';
    case Arabic             = 'ar';
    case Armenian           = 'hy';
    case Azerbaijani        = 'az';
    case Basque             = 'eu';
    case Belarusian         = 'be';
    case Bengali            = 'bn';
    case Bosnian            = 'bs';
    case Bulgarian          = 'bg';
    case Catalan            = 'ca';
    case CentralKhmer       = 'km';
    case Chinese            = 'zh_CN';
    case ChineseHongKong    = 'zh_HK';
    case ChineseT           = 'zh_TW';
    case Croatian           = 'hr';
    case Czech              = 'cs';
    case Danish             = 'da';
    case Dutch              = 'nl';
    case English            = 'en';
    case Estonian           = 'et';
    case Finnish            = 'fi';
    case French             = 'fr';
    case Galician           = 'gl';
    case Georgian           = 'ka';
    case German             = 'de';
    case GermanSwitzerland  = 'de_CH';
    case Greek              = 'el';
    case Gujarati           = 'gu';
    case Hebrew             = 'he';
    case Hindi              = 'hi';
    case Hungarian          = 'hu';
    case Icelandic          = 'is';
    case Indonesian         = 'id';
    case Italian            = 'it';
    case Japanese           = 'ja';
    case Kannada            = 'kn';
    case Kazakh             = 'kk';
    case Korean             = 'ko';
    case Latvian            = 'lv';
    case Lithuanian         = 'lt';
    case Macedonian         = 'mk';
    case Malay              = 'ms';
    case Marathi            = 'mr';
    case Mongolian          = 'mn';
    case Nepali             = 'ne';
    case NorwegianBokmal    = 'nb';
    case NorwegianNynorsk   = 'nn';
    case Occitan            = 'oc';
    case Pashto             = 'ps';
    case Persian            = 'fa';
    case Pilipino           = 'fil';
    case Polish             = 'pl';
    case Portuguese         = 'pt';
    case PortugueseBrazil   = 'pt_BR';
    case Romanian           = 'ro';
    case Russian            = 'ru';
    case Sardinian          = 'sc';
    case SerbianCyrillic    = 'sr_Cyrl';
    case SerbianLatin       = 'sr_Latn';
    case SerbianMontenegrin = 'sr_Latn_ME';
    case Sinhala            = 'si';
    case Slovak             = 'sk';
    case Slovenian          = 'sl';
    case Spanish            = 'es';
    case Swahili            = 'sw';
    case Swedish            = 'sv';
    case Tagalog            = 'tl';
    case Tajik              = 'tg';
    case Thai               = 'th';
    case Turkish            = 'tr';
    case Turkmen            = 'tk';
    case Uighur             = 'ug';
    case Ukrainian          = 'uk';
    case Urdu               = 'ur';
    case UzbekCyrillic      = 'uz_Cyrl';
    case UzbekLatin         = 'uz_Latn';
    case Vietnamese         = 'vi';
    case Welsh              = 'cy';

    public static function collection(): Collection
    {
        return collect(self::cases());
    }
}
