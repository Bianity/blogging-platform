<?php

namespace App\Exceptions;

use Exception;

class ThemeBasePathNotDefined extends Exception
{
    public function __construct()
    {
        parent::__construct('Theme base path is not defined');
    }
}
