<?php

namespace App\Exceptions;

use Exception;

class InvalidReportUser extends Exception
{
    public static function notDefined()
    {
        return new static('Report user not defined.');
    }

    public static function invalidReportByUser()
    {
        return new static('Invalid Report user.');
    }
}
