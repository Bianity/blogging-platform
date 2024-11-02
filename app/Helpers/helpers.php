<?php

use App\Managers\EditorJS\BlocksManager;
use App\Settings\AdvancedSettings;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Log;

if (! \function_exists('setupCompleted')) {
    function setupCompleted(): string
    {
        try {
            return app(GeneralSettings::class)->setup_completed;
        } catch (PDOException $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}

if (! function_exists('is_demo_mode')) {
    /**
     * Check if is demo mode.
     */
    function is_demo_mode(): bool
    {
        return env('DEMO_MODE', true) && getCurrentUser()->email === 'demo@bianity.me';
    }
}

if (! \function_exists('setEnvironmentValue')) {
    /**
     * Function to set or update .env variable.
     */
    function setEnvironmentValue(array $values): bool
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (\count($values) > 0) {
            $str .= "\n"; // In case the searched variable is in the last line without \n
            foreach ($values as $envKey => $envValue) {
                if ($envValue === true) {
                    $value = 'true';
                } elseif ($envValue === false) {
                    $value = 'false';
                } else {
                    $value = $envValue;
                }

                $envKey = mb_strtoupper($envKey);
                $keyPosition = mb_strpos($str, "{$envKey}=");
                $endOfLinePosition = mb_strpos($str, "\n", $keyPosition);
                $oldLine = mb_substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $space = mb_strpos($value, ' ');
                $envValue = $space === false ? $value : '"'.$value.'"';

                // If key does not exist, add it
                if (! $keyPosition || ! $endOfLinePosition || ! $oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
                env($envKey, $envValue);
            }
        }

        $str = mb_substr($str, 0, -1);

        if (! file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
}

if (! \function_exists('getCurrentUser')) {
    /**
     * Function to get current user.
     */
    function getCurrentUser()
    {
        return auth()->user();
    }
}

if (! \function_exists('getCurrentDisk')) {
    /**
     * Function to get current file storage disk.
     */
    function getCurrentDisk(): string
    {
        return app(AdvancedSettings::class)->current_file_storage;
    }
}

if (! \function_exists('cleanUrl')) {
    /**
     * Clean Url - like google.com.
     */
    function cleanUrl($input)
    {
        return preg_replace('/\b((https?|ftp|file):\/\/|www\.)*/i', '', preg_replace('{/$}', '', urldecode($input)));
    }
}

if (! \function_exists('makeClickableLinks')) {
    /**
     * Make Clickable Links in comment.
     */
    function makeClickableLinks($s)
    {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" class="comment-body" target="_blank">$1</a>', $s);
    }
}

if (! \function_exists('replaceIntentTweet')) {
    /**
     * Twitter intent with % sign is not working because it needs to be encoded.
     */
    function replaceIntentTweet($title)
    {
        return str_replace('%', '%25', $title);
    }
}

if (! \function_exists('convertToHtml')) {
    /**
     * Convert EditorJsData to html.
     */
    function convertToHtml($data)
    {
        $blocks = new BlocksManager($data);

        return $blocks->renderHtml();
    }
}

if (! \function_exists('getFirstParagraph')) {
    /**
     * Get First Paragraph from EditorJsData.
     */
    function getFirstParagraph($data)
    {
        $blocks = new BlocksManager($data);
        $p = $blocks->renderFirstParagraph();
        $string = substr($p, 0, strpos($p, '</p>') + 4);
        $string = strip_tags($string);
        if (strlen($string) > 500) {
            // truncate string
            $stringCut = substr($string, 0, 500);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = ($endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0)).' ...';
        }

        return $string;
    }
}

if (! \function_exists('in_multidimensional_array')) {
    function in_multidimensional_array($value, $array, $strict = false)
    {
        foreach ($array as $item) {
            if (($strict ? $item === $value : $item == $value) || (is_array($item) && in_multidimensional_array($value, $item))) {
                return true;
            }
        }

        return false;
    }
}

if (! \function_exists('getAppURL')) {
    /** Get URL of Website */
    function getAppURL()
    {
        $url = '';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url .= 'https://';
        } else {
            $url .= 'http://';
        }
        $url .= $_SERVER['HTTP_HOST'];

        return $url;
    }
}

if (! \function_exists('smart_wordwrap')) {
    function smart_wordwrap($string, $width = 75, $break = "\n")
    {
        // split on problem words over the line length
        $pattern = sprintf('/([^ ]{%d,})/', $width);
        $output = '';
        $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        foreach ($words as $word) {
            if (false !== strpos($word, ' ')) {
                // normal behaviour, rebuild the string
                $output .= $word;
            } else {
                // work out how many characters would be on the current line
                $wrapped = explode($break, wordwrap($output, $width, $break));
                $count = $width - (strlen(end($wrapped)) % $width);

                // fill the current line and add a break
                $output .= substr($word, 0, $count).$break;

                // wrap any remaining characters from the problem word
                $output .= wordwrap(substr($word, $count), $width, $break, true);
            }
        }

        // wrap the final output
        return wordwrap($output, $width, $break);
    }
}

if (! \function_exists('find_problem_word')) {
    function find_problem_word($string)
    {
        function reduce($v, $p)
        {
            return strlen($v) > strlen($p) ? $v : $p;
        }
        // Find problem word
        $problem_word = array_reduce(str_word_count($string, 1), 'reduce');

        if (strlen($problem_word) >= 70) {
            return;
        }

        return $string;
    }
}
