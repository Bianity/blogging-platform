<?php

namespace App\Events\Favorite;

use App\Models\Favorite;

class Event
{
    public Favorite $favorite;

    /**
     * Event constructor.
     */
    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }
}
