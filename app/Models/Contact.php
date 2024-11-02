<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtmlInput;

class Contact extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name'  => CleanHtmlInput::class,
        'email'  => CleanHtmlInput::class,
        'subject'  => CleanHtmlInput::class,
        'message'  => CleanHtmlInput::class,
    ];
}
